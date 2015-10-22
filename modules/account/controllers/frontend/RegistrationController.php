<?php

namespace app\modules\account\controllers\frontend;

use Yii;

use app\helpers\LetHelper;
use app\helpers\StringHelper;

use app\components\FrontendController;

use app\modules\account\models\User;
use app\modules\account\models\UserExtra;


class RegistrationController extends FrontendController
{

    public function actionRegister()
    {
        $model = new User(['scenario' => 'register']);

        $oauth = false; // Dung kiem tra xem co dang ky qua OAuth hay ko
        if (($oauthParam = Yii::$app->request->getQueryParam('oauth')) != null) {
            if (($oauthData = StringHelper::decrypt($oauthParam)) != null) {
                $oauth = true;
                if ($model->email === null)
                    $model->email = $oauthData['email'];
                if ($model->display_name === null)
                    $model->display_name = $oauthData['name'];
            }
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            // Default value
            $model->status = User::STATUS_ACTIVE;

            // Bỏ qua bước xác thực khi đăng ký qua OAuth
            if ($oauth === true && !empty($oauthData)) {
                $model->openids = [
                    $oauthData['provider'] => $oauthData['uid']
                ];
            }

            if ($model->save()) {
                Yii::$app->user->login($model);
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionRegisterExtra()
    {
        $model = new User(['scenario' => 'register']);
        $modelExtra = new UserExtra();

        $oauth = false; // Dung kiem tra xem co dang ky qua OAuth hay ko
        if (($oauthParam = Yii::$app->request->getQueryParam('oauth')) != null) {
            if (($oauthData = StringHelper::decrypt($oauthParam)) != null) {
                $oauth = true;
                if ($model->email === null)
                    $model->email = $oauthData['email'];
                if ($model->display_name === null)
                    $model->display_name = $oauthData['name'];
            }
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate() AND ($modelAdditionBlocks = LetHelper::saveAdditionBlocks($model))) {
            // Default value
            $model->status = User::STATUS_ACTIVE;

            // Bỏ qua bước xác thực khi đăng ký qua OAuth
            if ($oauth === true && !empty($oauthData)) {
                $model->openids = [
                    $oauthData['provider'] => $oauthData['uid']
                ];
            }

            if ($model->save()) {
                if (is_array($modelAdditionBlocks)) {
                    foreach($modelAdditionBlocks as $modelAdditionBlock) {
                        $modelAdditionBlock->_id = (String) $model->_id;
                        $modelAdditionBlock->save();
                    }
                }

                Yii::$app->user->login($model);
                return $this->goHome();
            }
        }

        return $this->render('registerExtra', [
            'model' => $model,
            'modelExtra' => $modelExtra,
        ]);
    }

    public function actionRegisterAjax()
    {
        Yii::$app->response->format = 'json';

        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                'status' => 1
            ];
        }

        return [
            'status' => 0
        ];
    }

    // Confirms a user (requires id and token query params)
    public function actionConfirm()
    {

    }

    // Displays resend form
    public function actionResend()
    {

    }
}
