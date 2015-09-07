<?php

namespace app\modules\account\models;

use Yii;

class AuthItemChild extends BaseAuthItemChild {

    public static function updateTreeRole($roles, $parent = null) {
        var_dump($roles);
        if (is_array($roles) AND ! empty($roles)) {
            foreach ($roles as $role) {
                if (isset($role->children)) {
                    self::updateTreeRole($role->children, $role->id);
                }

                self::deleteAll([
                    'child' => $role->id,
                ]);
                
                if (!empty($parent)) {
                    $model = new self;
                    $model->parent = $parent;
                    $model->child = $role->id;
                    $model->save();
                }
            }
        }
    }

}
