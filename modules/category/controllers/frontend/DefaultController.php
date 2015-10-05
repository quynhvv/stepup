<?php

namespace app\modules\category\controllers\frontend;

use Yii;
use app\modules\category\models\Category;
use app\components\FrontendController;
use yii\base\Exception;
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

    public function actionList($module, $id)
    {
        $modelClassName = ucfirst($module);
        $modelClass = "\\app\\modules\\{$module}\\models\\{$modelClassName}";

        if (!class_exists($modelClass)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (($category = Category::findOne($id)) == NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $obj = Yii::createObject($modelClass);
        $query = $obj::find()->where(['status' => '1', 'category' => $category->primaryKey]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC,
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('list', [
            'category' => $category,
            'dataProvider' => $dataProvider
        ]);
    }
}
