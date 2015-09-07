<?php

namespace app\modules\category\models;

use letyii\mongonestedset\NestedSetsQueryBehavior;

class CategoryQuery extends \yii\mongodb\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
