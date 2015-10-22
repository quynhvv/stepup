<?php
/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>
 */

namespace app\modules\account\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    const STATUS_INACTIVE = "0";
    
    const STATUS_ACTIVE = "1";
    
//    const STATUS_DELETED = 2;

    public $password;
    
    public $rememberMe = true;

    /*
     * OpenId
     */
    public $openId;
    
    /*
     * OpenId name service
     */
    public $nameService;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $data = parent::attributeLabels();
        $data['password'] = Yii::t('account', 'Password');
        $data['rememberMe'] = Yii::t('account', 'Remember');
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'display_name', 'first_name', 'last_name', 'openids', 'phone', 'password', 'password_hash', 'password_reset_token', 'auth_key', 'role', 'create_time', 'update_time', 'status'], 'safe'],
            [['email', 'phone'], 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email address has already been taken.', 'on' => ['default', 'register']],
            ['email', 'exist', 'message' => 'There is no user with such email.', 'on' => 'requestPasswordResetToken'],
            ['phone', 'unique', 'message' => 'This phone number has already been taken.'],
            ['password', 'required', 'on' => 'register'],
            ['password', 'string', 'min' => 6, 'max' => 20],

            [['email', 'password'], 'required', 'on' => 'login'],
            ['password', 'validatePasswordRule', 'on' => 'login'],
            ['rememberMe', 'boolean', 'on' => 'login'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['email', 'display_name', 'first_name', 'last_name', 'openids', 'phone', 'password', 'status'],
            'search' => ['_id', 'email', 'phone', 'status'],
            'login' => ['email', 'password'],
            'login_openid' => ['openId', 'nameService'],
            'register' => ['email','display_name', 'password', 'phone'],
//            'resetPassword' => ['password'],
//            'requestPasswordResetToken' => ['email'],
        ];
    }

    public function validatePasswordRule($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::findByEmail($this->email);

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = bin2hex(Yii::$app->getSecurity()->generateRandomKey());
                $this->auth_key = substr($this->auth_key, 0, 32);
            }
            return true;
        }
        return false;
    }

    public function search($params, $pageSize = 20)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        
        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'role' => $this->role,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->orderBy('_id ASC');
        return $dataProvider;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return null|User
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds user by OpenId
     *
     * @param string $id
     * @param string $nameService
     * @return null|User
     */
    public static function findByOpenId($id, $nameService)
    {
        if (empty($nameService) OR empty($id))
            return null;
            
        return static::findOne(['openids.' . $nameService => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return (string) $this->_id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function login($model = null)
    {
        if (empty($model)) {
            $model = self::findByEmail($this->email);
        }
        
        if ($this->validate() AND Yii::$app->user->login($model, $this->rememberMe ? 3600 * 24 * 30 : 0)) {
            return true;
        }
        return false;
    }
    
    public static function getAvatarUser($id){
        $model = self::findIdentity($id);
        return (empty($model->avatar))?'':$model->avatar;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => static::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = 3600;
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
