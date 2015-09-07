<?php
/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>
 */

namespace app\components;

use yii\helpers\Html;

class MongodbManager extends \letyii\rbacmongodb\MongodbManager
{
    
    /**
     * Create tree from array
     * @param array $tree
     * @param string $result
     * @param array $htmlOptions
     */
    public function createTreeHtml($tree, &$result = '', $htmlOptions = array()) {
        $result .= Html::beginTag('ol', $htmlOptions);
        foreach ($tree as $role => $child) {
            $result .= Html::beginTag('li',['class' => 'dd-item', 'data-id' => $role]);
            $result .= '<div class="btn-group pull-right">'
                    . '<span class="btn btn-info btn-xs" onclick="window.location.href=\''.\yii\helpers\Url::to(['/account/backend/rbac/childpermission','role' => $role]).'\'"><i class="fa fa-plus-square-o"></i></span>'
                    . '<span class="btn btn-info btn-xs" onclick="createRoleForm(\''.$role.'\')"><i class="fa fa-pencil"></i></span>'
                    . '<span class="btn btn-danger btn-xs" onclick="deleteRole(\''.$role.'\')"><i class="fa fa-trash-o"></i></span></div>';
            $result .= '<div class="dd-handle"> ' . $child['title'] . '</div>';
            if (isset($child['items']) AND !empty($child['items']))
                $this->createTreeHtml($child['items'], $result);
            $result .= Html::endTag('li');
        }
        $result .= Html::endTag('ol');
    }
    
    public function createTreeAssignHtml($tree, &$result = '', $assignments = [], $htmlOptions = array()) {
        $result .= Html::beginTag('ol', $htmlOptions);
        foreach ($tree as $role => $child) {
            $checked = (in_array($role, $assignments))?'checked':'';
            $result .= Html::beginTag('li',['class' => 'dd-item', 'data-id' => $role]);
            $result .= '<div class="btn-group pull-right">';
            $result .= '<input type="checkbox" '.$checked.' class="assignCheckbox" name="assign" value="'.$role.'"/>';
            $result .= '</div>';
            $result .= '<div class="dd-handle"> ' . $child['title'] . '</div>';
            if (isset($child['items']) AND !empty($child['items']))
                $this->createTreeAssignHtml($child['items'], $result, $assignments);
            $result .= Html::endTag('li');
        }
        $result .= Html::endTag('ol');
    }
}