<?php

namespace app\modules\account\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for collection "auth_action_list".
 *
 * @property \MongoId|string $_id
 * @property mixed $module
 * @property mixed $action
 * @property mixed $is_permission
 */
class AuthActionList extends BaseAuthActionList {

    public static $controllers = [];
    
    public static $actions = [];

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['_id', 'module', 'app', 'controller', 'action', 'is_permission'],
            'search' => ['_id', 'module', 'app', 'controller', 'action', 'is_permission'],
        ];
    }
    
    public static function getActionsFromSource() {
        $items = [];
        
        $modules = self::getModules();
        foreach ($modules as $module) {
            $controllerPath = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'modules/' . $module . '/controllers';
            self::getControllersInPath($controllerPath, $module);
        }
        
        foreach (self::$controllers as $controller) {
            self::getActionsInController($controller);
        }
        
        return self::insertActionList();
    }

    public static function insertActionList() {
        foreach (self::$actions as $action) {
            $model = self::findOne([
                'module' => $action['module'],
                'app' => $action['app'],
                'controller' => $action['controller'],
                'action' => '*',
            ]);
            if (!$model) {
                $id = [];
                $id[] = $action['module'];
                if (!empty($action['app']))
                    $id[] = $action['app'];
                $id[] = $action['controller'];
                $id[] = '*';
                $id = strtolower(implode('/', $id));
                
                $model = new self;
                $model->_id = $id;
                $model->module = $action['module'];
                $model->app = $action['app'];
                $model->controller = $action['controller'];
                $model->action = '*';
                $model->is_permission = 0;
                $model->save();
            }
            
            $model = self::findOne([
                'module' => $action['module'],
                'app' => $action['app'],
                'controller' => $action['controller'],
                'action' => $action['action'],
            ]);
            if (!$model) {
                $id = [];
                $id[] = $action['module'];
                if (!empty($action['app']))
                    $id[] = $action['app'];
                $id[] = $action['controller'];
                $id[] = $action['action'];
                $id = strtolower(implode('/', $id));
                
                $model = new self;
                $model->_id = $id;
                $model->module = $action['module'];
                $model->app = $action['app'];
                $model->controller = $action['controller'];
                $model->action = $action['action'];
                $model->is_permission = 0;
                $model->save();
            }
        }
        return true;
    }

    public static function getControllersInPath($path, $module = '', $app = '') {
        if (!file_exists($path))
            return false;
        
        $entrys = scandir($path);
        foreach ($entrys as $entry) {
            if (in_array($entry, ['.', '..']))
                continue;
            
            $entryPath = $path . DIRECTORY_SEPARATOR . $entry;
            if (is_dir($entryPath)) {
                self::getControllersInPath($entryPath, $module, $entry);
            } else {
                if (strstr($entry, 'Controller.php')) {
                    self::$controllers[] = [
                        'module' => $module,
                        'app' => $app,
                        'controller' => substr($entry, 0, -14),
                    ];
                }
            }
        }
        return true;
    }
    
    public static function getModelsInModule($path = '',$module = '', $app = 'backend', $models = []){
        if (empty($path))
            $path = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'modules/' . $module . '/models';
        
        // Neu khong ton tai path thi tra ve null
        if (!file_exists($path))
            return null;
        
        $entrys = scandir($path);
        foreach ($entrys as $entry) {
            if (in_array($entry, ['.', '..']))
                continue;
            
            $entryPath = $path . DIRECTORY_SEPARATOR . $entry;
            if (is_dir($entryPath)) {
                self::getModelsInModule($entryPath, $module, $entry, $models);
            } else {
                if (!strstr($entry, 'Base')) {
                    $entry = substr($entry, 0, -4);
                    $models['app\modules\\'. $module .'\models\\' . $entry] = 'app\modules\\'. $module .'\models\\' . $entry;
                }
            }
        }
        
        return $models;
    }

    public static function getModules() {
        $modules = \app\components\Common::getModules();

        $key = array_search('gii', $modules);
        unset($modules[$key]);

        $key = array_search('debug', $modules);
        unset($modules[$key]);

        return $modules;
    }
    
    public static function getActionsInController($controller){
        $controllerClass = $controller['controller'] . 'Controller';
        $namespaceController = (empty($controller['app'])) ? '\\app\modules\\' . $controller['module'] . '\\controllers\\' . $controllerClass : '\\app\modules\\' . $controller['module'] . '\\controllers\\' . $controller['app'] . '\\' . $controllerClass;
        $actions = get_class_methods($namespaceController);
        $actionList = [];
        foreach ($actions as $action) {
            if (preg_match('/^action/', $action) AND $action !== 'actions')
                $actionList[] = substr ($action, 6);
        }
//        $actionList = array_unique($actionList);
        foreach ($actionList as $action) {
            self::$actions[] = [
                'module' => $controller['module'],
                'controller' => $controller['controller'],
                'app' => $controller['app'],
                'action' => $action,
            ];
        }
    }
    
    public function search($params, $pageSize = 200)
    {
        $query = self::find();
        $query->orderBy('_id ASC');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        
        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_permission' => $this->is_permission,
        ]);

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'app', $this->app])
            ->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'action', $this->action]);

        return $dataProvider;
    }

}
