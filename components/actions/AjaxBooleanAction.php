<?php
namespace app\components\actions;

use yii\base\Action;
use Yii;

class AjaxBooleanAction extends Action
{
    public $modelClass;
    public $statusField = 'status';

    public function run($id)
    {
        Yii::$app->response->format = 'json';

        $obj = \Yii::createObject([
            'class' => $this->modelClass,
        ]);

        if (($model = $obj::findOne($id)) === null) {
            return ['s' => 0];
        }

        $model->{$this->statusField} = (string) (($model->{$this->statusField} == 1) ? 0 : 1);

        return [
            's' => ($model->save()) ? 1 : 0
        ];
    }
}
