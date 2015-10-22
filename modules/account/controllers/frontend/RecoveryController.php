<?php

namespace app\modules\account\controllers\frontend;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

use app\components\FrontendController;

use app\modules\account\models\PasswordRequestForm;
use app\modules\account\models\PasswordResetForm;


class RecoveryController extends FrontendController
{
    public function actionRequest()
    {
        $model = new PasswordRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('flash', [
                    'type' => 'success',
                    'title' => Yii::t('account', 'Message'),
                    'message' => Yii::t('account', 'Check your email for further instructions.'),
                    'duration' => 10000
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('flash', [
                    'type' => 'error',
                    'title' => Yii::t('account', 'Message'),
                    'message' => Yii::t('account', 'Sorry, we are unable to reset password for email provided.'),
                    'duration' => 10000
                ]);
            }
        }

        return $this->render('request', [
            'model' => $model,
        ]);
    }

    public function actionReset($token)
    {
        try {
            $model = new PasswordResetForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('flash', [
                'type' => 'success',
                'title' => 'Message',
                'message' => Yii::t('account', 'New password was saved.'),
                'duration' => 10000
            ]);

            return $this->goHome();
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}
