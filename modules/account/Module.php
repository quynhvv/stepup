<?php

namespace app\modules\account;

use Yii;

class Module extends \app\components\Module
{
    public $controllerNamespace = 'app\modules\account\controllers';
    
    public $iconClass = 'user';
    
    public $backendMenu = [];
    
    /**
     * Quy dinh danh sach cac thanh phan thong tin mo rong ngoai bang user
     * Vi du: Bang user_extra | user_config
     * @var array
     */
    public $additionBlocks = [];

    public function init()
    {
        // Menu for backend
        $this->backendMenu = [
            [
                'label' => Yii::t('account', 'Edit Information'),
                'url' => ['/account/default/editinformation'],
                'access' => [
                    'account/backend/default/editinformation'
                ]
            ],
            [
                'label' => Yii::t('account', 'Edit Avatar'),
                'url' => ['/account/default/editavatar'],
                'access' => [
                    'account/backend/default/editavatar'
                ]
            ],
            [
                'label' => Yii::t('account', 'Account'),
                'url' => ['/account/default'],
                'access' => [
                    'account/backend/default/*'
                ]
            ],
            [
                'label' => Yii::t('account', 'Role'),
                'url' => ['/account/rbac/role'],
                'access' => [
                    'account/backend/rbac/role'
                ]
            ],
            [
                'label' => Yii::t('account', 'Permission'),
                'url' => ['/account/rbac/permission'],
                'access' => [
                    'account/backend/rbac/permission'
                ]
            ],
            [
                'label' => Yii::t('account', 'Action list'),
                'url' => ['/account/rbac/actionlist'],
                'access' => [
                    'account/backend/rbac/actionlist'
                ]
            ],
        ];

        parent::init();

        // custom initialization code goes here
    }
}
