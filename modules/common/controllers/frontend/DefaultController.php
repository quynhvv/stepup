<?php

namespace app\modules\common\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\common\models\ContactForm;
use app\modules\question\models\Question;
use yii\data\ActiveDataProvider;

class DefaultController extends FrontendController
{
    public function actionIndex()
    {
//        $newQuestion = Question::find()
//                ->where(['status' => 1])
//                ->orderBy('_id DESC')
//                ->one();
//        
//        $answersQuestion = Question::find()
//                ->where([
//                    'status' => 1,
//                    'count_comment' => 0
//                ])
//                ->orderBy('_id DESC')
//                ->one();

        return $this->render('index');
    }

    public function actionInfomation()
    {
        $this->layout = '//infomation';
        return $this->render('infomation');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
}
