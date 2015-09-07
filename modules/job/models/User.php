<?php

namespace app\modules\job\models;

use Yii;

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
            }
        }
    }

}
