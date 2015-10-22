<?php

namespace app\modules\job\models;

use app\helpers\LetHelper;
use Yii;
use app\helpers\ClientHelper;
use app\helpers\FileHelper;
use app\helpers\StringHelper;

class User extends \app\modules\account\models\User
{

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['email', 'unique', 'message' => 'This email address has already been taken.', 'on' => ['register_seeker', 'register_recruiter', 'register_employer', 'edit_recruiter']],
            [['email', 'password'], 'required', 'on' => ['register_seeker', 'register_recruiter', 'register_employer']],
            [['first_name', 'last_name', 'phone'], 'required', 'on' => ['register_recruiter', 'register_employer']],
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'register_seeker' => ['email', 'password'],
            'register_recruiter' => ['email', 'password', 'first_name', 'last_name', 'phone'],
            'register_employer' => ['email', 'password', 'first_name', 'last_name', 'phone'],
            'edit_recruiter' => ['email', 'first_name', 'last_name', 'phone'],
        ]);
    }

    public function validatePasswordRule($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::findByEmail($this->email);

            if (!$user) {
                $this->addError($attribute, Yii::t('account', 'Account not found.'));
            } elseif (!$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('account', 'Incorrect username or password.'));
            } elseif (($modelJob = UserJob::find()->where(['_id' => $user->primaryKey, 'role' => $this->role])->one()) == null) {
                $this->addError($attribute, Yii::t('account', 'Invalid Account. You are not allowed to access this page.'));
            } else {
                // Kiem tra xem Seeker da co day du thong tin Resume chua?
                if ($this->role == 'seeker' && ($modelUserJobSeekerResume = UserJobSeekerResume::findOne($user->primaryKey)) != null) {
                    Yii::$app->session->set('jobAccountResume', 1);
                }
                Yii::$app->session->set('jobAccountRole', $this->role);
            }
        }
    }

    public function beforeSave($insert) {
        $attributes = array_keys($this->getAttributes());

        // ID
        if ($this->isNewRecord AND empty($this->_id))
            $this->_id = uniqid();
        // SEO
        if (in_array('title', $attributes) AND in_array('seo_url', $attributes) AND empty($this->seo_url))
            $this->seo_url = StringHelper::asUrl($this->title);
        if (in_array('title', $attributes) AND in_array('seo_title', $attributes) AND empty($this->seo_title))
            $this->seo_title = $this->title;
        if (in_array('description', $attributes) AND in_array('seo_desc', $attributes) AND empty($this->seo_desc))
            $this->seo_desc = $this->description;

        // Upload image
        $image = \yii\web\UploadedFile::getInstance($this, 'image');
        if (!empty($image)) {
            $this->image = \yii\web\UploadedFile::getInstance($this, 'image');
            $ext = FileHelper::getExtention($this->image);
            if (!empty($ext)) {
                $fileDir = LetHelper::getAvatarDir($this->primaryKey) . '/';
                $fileName = $this->primaryKey . '.jpg';
                //$fileName = $this->primaryKey . '.' . $ext;
                $folder = Yii::$app->params['uploadPath'] . '/' . Yii::$app->params['uploadDir'] . '/' . $fileDir;
                FileHelper::createDirectory($folder);
                $this->image->saveAs($folder . $fileName);
                $this->image = $fileDir . $fileName;
            }
        } else {
            $this->image = $this->image_old;
        }

        // creator, editor and time
        $now = new \MongoDate();
        if (in_array('update_time', $attributes) AND empty($this->update_time))
            $this->update_time = $now;
        if (in_array('editor', $attributes) AND ! ClientHelper::isCommandLine())
            $this->editor = Yii::$app->user->id;
        if ($this->isNewRecord) {
            if (in_array('creator', $attributes) AND ! ClientHelper::isCommandLine())
                $this->creator = Yii::$app->user->id;
            if (in_array('create_time', $attributes) AND $this->create_time == null)
                $this->create_time = $now;
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }
        if ($this->isNewRecord) {
            $this->auth_key = bin2hex(Yii::$app->getSecurity()->generateRandomKey());
            $this->auth_key = substr($this->auth_key, 0, 32);
        }

        return true;
    }
    
    public function getUserJob()
    {
        return $this->hasOne(UserJob::className(), ['_id' => '_id']);
    }

    public function getUserSeekerResume()
    {
        return $this->hasOne(UserJobSeekerResume::className(), ['_id' => '_id']);
    }
}
