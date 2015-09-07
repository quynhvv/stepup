<?php

/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>
 */

namespace app\modules\account\controllers\backend;

use Yii;
use yii\mongodb\Query;
use app\modules\account\models\AuthItem;
use app\modules\account\models\AuthItemChild;
use app\modules\account\models\AuthActionList;
use yii\filters\VerbFilter;

class AjaxController extends \app\components\BackendController {
    
    public function behaviors() {
        $data = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $data);
    }

    public function actionCreatepermission() {
        $ids = Yii::$app->request->get('selection', []);

        $messages = [
            'success' => [],
            'error' => [],
            'exist' => [],
        ];

        foreach ($ids as $id) {
            $auth = Yii::$app->authManager;
            $model = AuthActionList::findOne($id);
            if (!$auth->checkItemExist($id) AND $model) {
                $createPermission = $auth->createPermission($id);
//                $createPost->description = 'Create a post';
                if ($auth->add($createPermission)) {
                    $model->is_permission = 1;
                    $model->save();
                    $messages['success'][] = $id;
                } else {
                    $messages['error'][] = $id;
                }
            } else {
                $messages['exist'][] = $id;
            }
        }

        echo json_encode($messages);
    }

    /**
     * Hàm gán các action, controller vào role.
     */
    public function actionAddchildpermission() {
        $role = Yii::$app->request->get('role');
        $selection = Yii::$app->request->get('selection', []);
        $allpermission = Yii::$app->request->post('allpermission', '');
        $allpermission = explode(',', $allpermission);
        $auth = Yii::$app->authManager;
        
        $msg = [
            'status' => 1,
            'msg' => 'Gán quyền thành công',
        ];

        if (empty($role)) {
            $msg = [
                'status' => 0,
                'msg' => 'Bạn chưa chọn role',
            ];
        } else {
            // Them vao role nhung permission duoc chon nhung chua co trong role
            foreach ($selection as $permissionChoice) {
                $model = AuthItemChild::findOne(['child' => $permissionChoice, 'parent' => $role]);
                if (!$model) {
                    $model = new AuthItemChild;
                    $model->parent = $role;
                    $model->child = $permissionChoice;
                    if (!$model->save()) {
                        $msg = [
                            'status' => 0,
                            'msg' => 'Có lỗi xảy ra khiến không thể lưu dữ liệu',
                        ];
                        break;
                    }
                }
                if(($key = array_search($permissionChoice, $allpermission)) !== false) {
                    unset($allpermission[$key]);
                }
            }
//            echo json_encode($allpermission);die;
            // Xoa nhung permission khong duoc check trong danh sach khoi role
            AuthItemChild::deleteAll([
                'in', 'child', $allpermission,
                'and', 'parent', $role
            ]);
        }
        
        echo json_encode($msg);

//        $allpermission = explode(',', $allpermission);
//        foreach ($allpermission as $permission) {
//            $childPermission = AuthItemChild::findOne(['child' => $permission, 'parent' => $role]);
//            // Kiểm tra permission có trong list permission submit hay không.
//            if (in_array($permission, $ids)) {
//                if (!$childPermission) {
//                    $child = new AuthItemChild;
//                    $child->parent = $role;
//                    $child->child = $permission;
//                    if ($child->save()) {
//                        $msg = [
//                            'status' => 1,
//                            'msg' => 'Gán quyền thành công',
//                        ];
//                    } else {
//                        $msg = [
//                            'status' => 0,
//                            'msg' => 'Có lỗi xảy ra, gán quyền không thành công',
//                        ];
//                    }
//                }
//            } else { // Nếu không có trong role thì xóa.
//                $child = new AuthItemChild;
//                if ($child->deleteAll(['child' => $permission, 'parent' => $role])) {
//                    $msg = [
//                        'status' => 1,
//                        'msg' => 'Gán quyền thành công',
//                    ];
//                }
//            }
//        }

        // Delete all child in role is permission.
//        $auth->removeChildrenByType($role, 2);
//
//        foreach ($ids as $id) {
//            $child = new AuthItemChild;
//            $child->parent = $role;
//            $child->child = $id;
//            if ($child->save()) {
//                $msg = [
//                    'status' => 1,
//                    'msg' => 'Gán quyền thành công',
//                ];
//            } else {
//                $msg = [
//                    'status' => 0,
//                    'msg' => 'Có lỗi xảy ra, gán quyền không thành công',
//                ];
//            }
//        }

//        echo json_encode($msg);
    }

    public function actionUpdaterole() {
        // Add role
        $name = Yii::$app->request->post('name', NULL);
        $description = Yii::$app->request->post('description');

        // Neu khong ton tai tieu de thi bao loi
        if (empty($description)) {
            $result = [
                'status' => 0,
                'message' => 'Bạn chưa nhập tiêu đề của vai trò',
            ];
            echo json_encode($result);
            die;
        }

        $auth = Yii::$app->authManager;
        if (!empty($name)) {
            $role = AuthItem::findOne(['name' => $name]);
            if ($role) {
                $role->description = $description;
                if ($role->save()) {
                    $result = [
                        'status' => 1,
                        'message' => 'Bạn đã sửa vai trò thành công',
                    ];
                } else {
                    $result = [
                        'status' => 0,
                        'message' => 'Có lỗi xảy ra, cập nhật không thành công',
                    ];
                }
            } else {
                $result = [
                    'status' => 0,
                    'message' => 'Không tồn tại vai trò này',
                ];
            }
        } else {
            $roleName = uniqid();
            $role = $auth->createRole($roleName);
            $role->description = $description;
            $auth->add($role);
            $result = [
                'status' => 2,
                'message' => 'Tạo vai trò thành công',
                'name' => $roleName,
            ];
        }
        echo json_encode($result);
    }

    /**
     * Hàm xóa role dựa vào name của role.
     * Lấy ra các role con của role xóa, update các role con vào role parent của role bị xóa.
     * Khi xóa role xóa các item child của role trong bảng child.     
     */
    public function actionDeleterole() {
        $name = Yii::$app->request->post('name', NULL);

        // Lấy ra parent của role bị xóa.
        $role = AuthItemChild::findOne(['child' => $name]);

        /**
         * Nếu role bị xóa có parent thì update các role con theo role parent bị xóa và xóa role child là role bị xóa.
         * Ngược lại thì xóa toàn bộ child của role bị xóa.       
         */
        if ($role) {
            $auth = Yii::$app->authManager;

            // Get all permission by role
            $allPermissionByRole = $auth->getPermissionsByRole($name);

            // Get all permission by role parent and delete permission in role remove if permission in role parent.
            $allPermissionByRoleParent = $auth->getPermissionsByRole($role->parent);
            $allPermissionByRoleParent = \yii\helpers\ArrayHelper::map($allPermissionByRoleParent, 'name', 'name');
            foreach ($allPermissionByRole as $permission) {
                if (in_array($permission->name, $allPermissionByRoleParent))
                    AuthItemChild::deleteAll(['child' => $permission->name, 'parent' => $name]);
            }

            // Lấy ra các role con của role bị xóa, và update vào role parent của role bị xóa.
            AuthItemChild::updateAll(['parent' => $role->parent], ['parent' => $name]);

            // Xóa chính nó trong bảng child.
            AuthItemChild::deleteAll(['child' => $name]);
        } else {
            AuthItemChild::deleteAll(['parent' => $name]);
        }

        // Xóa role
        AuthItem::deleteAll(['name' => $name]);

        $result = [
            'status' => 1,
            'message' => 'Xóa vai trò thành công',
        ];

        echo json_encode($result);
    }

    public function actionAddassign() {
        $user_id = Yii::$app->request->post('user_id', '');
        $roleName = Yii::$app->request->post('role', '');

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        $auth->assign($role, $user_id);
    }

    public function actionRevokeassign() {
        $user_id = Yii::$app->request->post('user_id', '');
        $roleName = Yii::$app->request->post('role', '');

        $auth = Yii::$app->authManager;
        $auth->revoke($roleName, $user_id);
    }

}
