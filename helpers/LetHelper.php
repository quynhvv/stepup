<?php

namespace app\helpers;

use Yii;
use app\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class LetHelper {

    const URL = 'url';
    
    const PATH = 'path';
    
    const IMAGE = 'image';

    /**
     * Get Module name by alias or module name (from url)
     * @param string $alias
     * @return moduleName
     */
    public static function getModuleByAlias($alias) {
        $modules = Yii::$app->modules;
        foreach ($modules as $moduleName => $module) {
            if (ArrayHelper::getValue($module, 'alias') == $alias OR $alias == $moduleName)
                return $moduleName;
        }
        return null;
    }

    /**
     * Get url or path file uploaded
     * @param string $file
     * @param string $type URL | PATH
     * @return type
     */
    public static function getFileUploaded($file, $type = self::URL) {
        if ($type == self::PATH)
            return Yii::$app->params['uploadPath'] . DIRECTORY_SEPARATOR . Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . $file;
        elseif ($type == self::URL) {
            return Yii::$app->params['uploadUrl'] . '/' . Yii::$app->params['uploadDir'] . '/' . $file;
        }
        return false;
    }
    
    /**
     * Get url or path avatar with user_id
     * @param string $user_id User ID
     * @param string $type IMAGE | URL | PATH
     * @param boolean $origin
     * @param int $size
     * @param array $options HTML options
     * @return string|boolean
     */
    public static function getAvatar($user_id, $type = self::URL, $origin = false, $size = 48, $options = []) {
        $dir = self::getAvatarDir($user_id);
        $fileName = $origin ? $user_id . '.original.jpg' : $user_id . '.jpg';
        $file = $dir . '/' . $fileName;
        if ($type == self::URL OR $type == self::PATH)
            return self::getFileUploaded($file, $type);
        elseif ($type == self::IMAGE) {
            $options['style'] = isset($options['style']) ? (string) $options['style'] : '';
            $options['style'] .= 'width:' . $size . 'px; height:' . $size . 'px';
            $path = self::getFileUploaded($file, self::PATH);
            $imageUrl = file_exists($path) ? self::getFileUploaded($file, self::URL) : Yii::getAlias('@web') . '/statics/images/noavatar_' . $size . '.png';
            return Html::img($imageUrl, $options);
        }
        return false;
    }

    /**
     * Get avatar dir with user_id
     * @param string $user_id User ID
     * @return string
     */
    public static function getAvatarDir($user_id) {
        $md5FileName = md5($user_id);
        $dir = 'account' . DIRECTORY_SEPARATOR . substr($md5FileName, 0, 2) . DIRECTORY_SEPARATOR . substr($md5FileName, 2, 2) . DIRECTORY_SEPARATOR . substr($md5FileName, 4, 2);
        return $dir;
    }
    
    /**
     * Tao cac tab Addition Block
     * @param object $modelParent model cua form mac dinh
     * @param object $form ActiveForm 
     * @param array $tabs cac tab cua Addition Block
     * @param string $pathView duong dan file view cua Addition Block
     * @return array $tabs
     */
    public static function buildAdditionBlocksForm($modelParent, $form, $tabs, $pathView) {
        $additionBlocks = Yii::$app->getModule($modelParent->moduleName)->additionBlocks;
        foreach ($additionBlocks as $collectionName => $namespace) {
            $viewFile = $pathView . DIRECTORY_SEPARATOR . '_' . $collectionName . '.php';
            if (file_exists($viewFile)) {
                if ($modelParent->isNewRecord OR !($model = $namespace::findOne($modelParent->_id))) {
                    $model = new $namespace;
                    $model->_id = $modelParent->_id;
                }
                $tabs = array_merge($tabs, require($viewFile));
            }
        }
        return $tabs;
    }
    
    /**
     * Luu du lieu cua cac Addition Block
     * @param object $modelParent model cua form mac dinh
     * @return false|array Neu validate cua 1 trong nhung Addition Block co gia tri bang false, thi ham tra ve false. Neu khong thi ham tra ve 1 mang bao gom cac model cua Addition Block
     */
    public static function saveAdditionBlocks($modelParent) {
        $validate = true;
        $models = [];
        $additionBlocks = Yii::$app->getModule($modelParent->moduleName)->additionBlocks;
        foreach ($additionBlocks as $collectionName => $namespace) {
            // Load model of collectionName
            if ($modelParent->isNewRecord OR !($model = $namespace::findOne($modelParent->_id))) {
                $model = new $namespace;
                $model->_id = $modelParent->_id;
            }
            
            // Load param to model
            if($model->load(Yii::$app->request->post())){
                $validate = $model->validate();
            }
            
            if (!$validate)
                return false;
            
            $models[$collectionName] = $model;
        }
        if (empty($models))
            return true;
        return $models;
    }
    
    /**
     * Ham tao cau dieu kien
     * @param object $query
     * @param string $attribute Ten attribute in collection
     * @param string|array $values Gia tri cua attribute
     * @param string|array $operator Dieu kien cua attribute va value: like, between, gt, gte, lt, lte
     * @return object $query
     */
    public static function addFilter($query, $attribute, $values, $operator = null){
        if ($operator == 'between' AND isset($values[1])) {
            $where = [
                $attribute => [
                    '$gte' => ArrayHelper::getValue($values, 0),
                    '$lte' => ArrayHelper::getValue($values, 1),
                ]
            ];
        } elseif (in_array($operator, ['gt', 'gte', 'lt', 'lte'])) {
            $where = [
                $attribute => [
                    '$' . $operator => $values,
                ]
            ];
        } elseif ($operator == 'like') {
            $where = [
                $attribute => [
                    '$regex' => $values,
                ]
            ];
        } else {
            $where = [
                $attribute => $values
            ];
        }
//        if (empty($operator)){// Neu operators rong thi attribute = values
//            $query->andFilterWhere([
//                $attribute => $values
//            ]);
//        } else if (!is_array($values) && !(is_array($operator))){
//            $query->andFilterWhere([
//                $attribute => [
//                    $operator => $values,
//                ]
//            ]);
//        } else {
//            // Tao dieu kien theo mang value va operators
//            $where = [];
//            foreach ($values as $key => $value) {
//                $operator = (isset($operators[$key])) ? $operators[$key] : '';
//                $where[$operator] = $value;
//            }
//            
//            $query->andFilterWhere([
//                $attribute => $where
//            ]);
//        }
        
        return $query->andFilterWhere($where);
    }
    
    /**
     * Ham lay gia tri cua value lam key tao thanh mang moi
     * @param array $items
     * @return array
     */
    public static function setValueForKey($items){
        $result = [];
        foreach ($items as $key => $value) {
            $result[$value] = $value; 
        }
        return $result;
    }

    public static function getLanguageOptions() {
        return [
            'vi' => Yii::t('common', 'Vietnamese'),
            'en' => Yii::t('common', 'English'),
        ];
    }
}
