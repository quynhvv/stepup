<?php

namespace app\modules\category\models;

use Yii;
use letyii\mongonestedset\NestedSetsBehavior;
use app\helpers\StringHelper;
use yii\helpers\Url;
use app\helpers\ArrayHelper;

class Category extends BaseCategory
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }
    
    public static function moduleName(){
        return 'category';
    }

    public function rules() {
        $data = [
            [['name'], 'required', 'on' => self::SCENARIO_DEFAULT],
        ];
        return array_merge(parent::rules(), $data);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
    public function getModulesInSource(){
        return self::getModules();
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
    
    /**
     * Get ra thong tin cua 1 row
     * 
     * @param string $id
     * @return Object|false
     */
    public static function get($id) {
        $cache_key = 'Category_get_' . $id;
        $cache = Yii::$app->cache->get($cache_key);
        if (!$cache) {
            $cache = self::findOne($id);
            Yii::$app->cache->set($cache_key, $cache);
        }
        return $cache;
    }
    
    /**
     * Get ra thong tin cua 1 attribute trong row
     * 
     * @param string $id
     * @param string $attribute
     * @return value|false
     */
    public static function getAttributeValue($id, $attribute) {
        $model = self::get($id);
        if ($model)
            return \app\helpers\ArrayHelper::getValue ($model, $attribute);
        return false;
    }
    
    public static function getModules() {
        // Get Module list
        $modules = array_keys(Yii::$app->modules);
        
        // Get sub menu for each module
        $result = [];
        foreach ($modules as $moduleName) {
            // Get module
            $moduleObj = Yii::$app->getModule($moduleName);
            
            // Get menu
            if (property_exists($moduleObj, 'hasCategory')){
                $result[$moduleName] = $moduleName;
            }
        }

        return $result;
    }
    
    public function generationUrl ($id = NULL, $title = NULL) {
        $attributes = array_keys($this->getAttributes());
        
        if (empty($id))
            $id = $this->primaryKey;

        // Create alias
        if (!empty($title))
            $alias = $title;
        elseif (in_array('seo_title', $attributes) AND !empty($this->seo_title))
            $alias = $this->seo_title;
        elseif (in_array('name', $attributes) AND !empty($this->name))
            $alias = $this->name;
        else
            $alias = '';
        $alias = StringHelper::asUrl($alias);
        
        if (empty($alias))
            $alias = '/danh-muc/' . $id;
        else
            $alias = '/danh-muc/' . $alias . '-' . $id;
        
        return $this->url = Url::to([$alias]);
    }
    
    public static function getCategory($module = '', $prefix = '') {
        $categorys = array();
        if (empty($module) OR !in_array($module, self::getModules()))
            $data = self::find()->addOrderBy('lft')->all();
        else {
            self::createRootIfNotExist($module);
            $data = self::find()
                ->where(['module' => $module])
//                ->andWhere('lft != 1')
                ->addOrderBy('lft')->all();
        }
        foreach ($data as $category) {
            $categorys[(string)$category->_id] = str_repeat($prefix, ($category->depth)) . $category->name;
        }
        return $categorys;
    }
    
    public static function createRootIfNotExist($module) {
        $root = self::find()
            ->where(['module' => $module])->andWhere(['lft' => 1])->addOrderBy('lft')->one();
        if ($root === NULL) {
            // Create root for module
            $root = new Category;
            $root->name = $module;
            $root->module = $module;
            $root->makeRoot();
        }
        return $root;
    }
    
    public static function updateTreeStructure($children = [], $parent = null, $module = null){
        if (empty($module) OR !is_array($children) OR empty($children))
            return false;
        
        if (empty($parent)){
            $parent = self::find()
                ->where(['module' => $module])->andWhere(['lft' => 1])->addOrderBy('lft')->one();
        }
        
        foreach ($children as $child) {
            $model = self::findOne(ArrayHelper::getValue($child, 'id'));
            if ($model) {
                $model->appendTo($parent);
                self::updateTreeStructure(ArrayHelper::getValue($child, 'children'), $model, $module);
            }
        }
        
        return true;
    }

}
