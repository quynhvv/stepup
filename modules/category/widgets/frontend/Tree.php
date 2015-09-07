<?php

namespace app\modules\category\widgets\frontend;

use Yii;
use yii\base\Widget;
use app\modules\category\models\Category;
use app\modules\question\models\Question;

class Tree extends Widget{
    
    public $title = '';

    public $module = null;

    public $category = null;
    
    public $view = null;

    public function init()
    {
        parent::init();
        if (empty($this->view))
            $this->view = (new \ReflectionClass($this))->getShortName();
    }

    public function run() {
        Yii::$app->cache->flush();
        $cacheKey = $this->module . '_Tree_' . $this->module . '_' . $this->category;
        $cache = Yii::$app->cache->get($cacheKey);
        if (!$cache) {
            $model = new Category;
            $where = [$model->leftAttribute => 1];
            if (!empty($this->module))
                $where['module'] = $this->module;

            if (!empty($this->category))
                $where['_id'] = $this->category;

            $models = Category::findOne($where);
            $models = $models->leaves()->all();
            Yii::$app->cache->set($cacheKey, $models);
        } else
            $models = $cache;
        
        if (!empty($models))
            return $this->render($this->view, [
                'models' => $models,
                'title' => $this->title,
                'module' => $this->module,
                'category' => $this->category,
            ]);

    }
    
}

