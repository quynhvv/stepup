<?php

namespace app\components;

use yii\web\ForbiddenHttpException;
use app\components\Module;
use Yii;
use yii\web\User;
use yii\di\Instance;

class AccessControl extends \yii\filters\AccessControl
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     * @var array List of action that not need to check access.
     */
    public $allowActions = [];

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $actionId = $action->getUniqueId();
        
        $user = $this->getUser();
        if ($user->can($actionId)) {
            return true;
        }
        $obj = $action->controller;
        do {
            if ($user->can(ltrim($obj->getUniqueId() . '/*', '/'))) {
                return true;
            }
            $obj = $obj->module;
        } while ($obj !== null);
        $this->denyAccess($user);
    }

    /**
     * @inheritdoc
     */
//    protected function isActive($action)
//    {
//        $uniqueId = $action->getUniqueId();
//        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
//            return false;
//        }
//
//        $user = $this->getUser();
//        if ($user->getIsGuest() && is_array($user->loginUrl) && isset($user->loginUrl[0]) && $uniqueId === trim($user->loginUrl[0], '/')) {
//            return false;
//        }
//
//        if ($this->owner instanceof Module) {
//            // convert action uniqueId into an ID relative to the module
//            $mid = $this->owner->getUniqueId();
//            $id = $uniqueId;
//            if ($mid !== '' && strpos($id, $mid . '/') === 0) {
//                $id = substr($id, strlen($mid) + 1);
//            }
//        } else {
//            $id = $action->id;
//        }
//
//        foreach ($this->allowActions as $route) {
//            if (substr($route, -1) === '*') {
//                $route = rtrim($route, "*");
//                if ($route === '' || strpos($id, $route) === 0) {
//                    return false;
//                }
//            } else {
//                if ($id === $route) {
//                    return false;
//                }
//            }
//        }
//
//        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
//            return false;
//        }
//
//        return true;
//    }
}