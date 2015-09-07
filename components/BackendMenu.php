<?php
/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>
 */

namespace app\components;

use Yii;
use kartik\icons\Icon;

class BackendMenu extends \yii\widgets\Menu {

    public $submenuTemplate = "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n";
    public $linkTemplate = '<a href="{url}">{label}</a>';
    public $encodeLabels = false;
    
    /**
     * Renders the menu.
     */
    public function run()
    {
        // Get Module list
        $modules = array_keys(Yii::$app->modules);
        
        // Get sub menu for each module
        foreach ($modules as $moduleName) {
            // Get module
            $moduleObj = Yii::$app->getModule($moduleName);
            
            $iconClass = (isset($moduleObj->iconClass)) ? $moduleObj->iconClass : 'fa-dashboard';
            // Get menu
            if (property_exists($moduleObj, 'backendMenu')){
                $getModule = Yii::$app->request->get('module');
                $item = ['label' => Icon::show($iconClass) . '<span class="nav-label">'.Yii::t($moduleName, ucfirst($moduleName)).'</span>', 'url' => ['/' . $moduleName . '/default']];
                if ((Yii::$app->controller->module->id == $moduleName AND empty($getModule)) OR $getModule == $moduleName)
                    $item['active'] = TRUE;
                
                $backendMenu = $moduleObj->backendMenu;
                if (is_array($backendMenu)) {
                    foreach ($backendMenu as $itemMenu) {
                        if (isset($itemMenu['access']) AND $this->checkAccess($itemMenu['access'])) {
                            $item['items'][] = [
                                'label' => $itemMenu['label'],
                                'url' => $itemMenu['url'],
                            ];
                        }
                    }
                    if (isset($item['items']) AND !empty($item['items']))
                        $item['label'] .= '<span class="fa arrow"></span>';
                }

                // assign to $this->items
                $this->items[] = $item;
            }
        }
        parent::run();
    }
    
    /**
     * Check permission(s) User
     * @param array|string $permission
     */
    protected function checkAccess($permissions) {
        if (is_string($permissions))
            $permissions = [$permissions];
        
        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }
        
        return false;
    }
}
