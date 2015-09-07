<?php

namespace app\modules\category\controllers\frontend;

use Yii;
use app\modules\category\models\Category;
use app\components\FrontendController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

use app\modules\article\models\Article;

class DefaultController extends FrontendController
{
    public function actionIndex($id)
    {
        $id = Yii::$app->request->get('id');
        
        
        $row = Category::find()
            ->where(['_id' => $id])
            ->one();  
        if($row != NULL)
        {
            //Lấy danh sách bài viết
            $article = Article::find()
                ->where(['category' => $row->_id])
                ->all();
        }
        else
            throw new NotFoundHttpException('The requested page does not exist.');
            
        return $this->render('index', ['row' => $row, 'article' => $article]);
        
    }
    

}
