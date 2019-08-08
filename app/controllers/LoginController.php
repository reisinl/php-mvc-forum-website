<?php


namespace app\controllers;

use core\base\Controller;
use app\models\Login;
use core\interfaces\iController;

class LoginController extends Controller implements iController
{
    protected $errorMsg;
    protected $userName;
    protected $userPwd;
    protected $userID;

    public function Index () {
        $this->assign('title', 'Login Page');
        $this->assign('errorMsg', $this->errorMsg);
        $this->assign('userName', $this->userName);
        $this->assign('userPwd', $this->userPwd);
        $this->render();
    }

    public function Login () {
        $this->userName = $_POST['userName'];
        $this->userPwd = $_POST['userPwd'];
        $this->errorMsg  = $this->LoginValidation($this->userName, $this->userPwd);
        if (strcmp($this->errorMsg, '')== 0) {
            $this->setUserSession($this->userID, $this->userName);
            $this->redirect("/home/index");
        }

        parent::__construct($this->_controller, "index");
        $this->Index();

    }

    private function LoginValidation ($userNm, $userPwd) {

        if ($userNm == '' || $userPwd == '') {
            return 'Please input your user name or password';
        }
        $item = (new Login())->search($userNm);
        $size = count($item);
        if ($size > 0) {
            $this->userID = $item[0]["id"];
            if (!password_verify($userPwd, $item[0]["login_pwd"])) {
                return 'Your user name or password is not correct.';
            }
        } else {
            return 'This user does not exist.';
        }
        return '';
    }

}