<?php

namespace app\modules\account\controllers\frontend;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\BadRequestHttpException;


class ProfileController extends Controller
{

    /**
     * Displays user's profile (requires id query param)
     * Hiển thị trang cá nhân cho người khác xem
     */
    public function actionView()
    {

    }

    /**
     * Trang dashboard của thành viên
     */
    //public function actionIndex()
    public function actionDashboard()
    {

    }

    /**
     * Displays account settings form (email, username, password)
     * Cập nhật thông tin
     */
    public function actionUpdate()
    {

    }

    /**
     * Displays profile settings form
     * Cài đặt ba cái thứ linh tinh:
     * - Đăng ký nhận mail
     * - ...
     */
    public function actionSettings()
    {

    }

    /**
     * Cho phép hủy account đã đăng ký
     */
    public function actionCancel()
    {

    }

}
