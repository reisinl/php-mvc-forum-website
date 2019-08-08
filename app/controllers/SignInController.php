<?php


namespace app\controllers;

use app\models\SignIn;
use config\Constant;
use core\base\Controller;
use core\interfaces\iController;

class SignInController extends Controller implements iController
{
    protected $errorMsg;
    protected $userName;
    protected $userPwd;
    protected $userPwdCfm;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $userID;

    public function Index () {
        $this->assign('title', 'Sign In Page');
        $this->assign('errorMsg', $this->errorMsg);
        $this->assign('userName', $this->userName);
        $this->assign('userPwd', $this->userPwd);
        $this->assign('userPwdCfm', $this->userPwdCfm);
        $this->assign('firstName', $this->firstName);
        $this->assign('lastName', $this->lastName);
        $this->assign('email', $this->email);
        $this->render();
    }


    public function SignIn () {
        $this->userName = $_POST['userName'];
        $this->userPwd = $_POST['userPwd'];
        $this->userPwdCfm = $_POST['userPwdCfm'];
        $this->firstName = $_POST['firstName'];
        $this->lastName = $_POST['lastName'];
        $this->email = $_POST['email'];
        $this->errorMsg = $this->SignInValidation();

        if (strcmp($this->errorMsg, '')== 0) {
            $this->DoRegistration();
            $this->redirect("/home/index");
        }

        parent::__construct($this->_controller, "index");
        $this->Index();
    }

    private function SignInValidation () {


        $userNm = $this->userName;
        $userPwd = $this->userPwd;
        $userPwdCfm = $this->userPwdCfm;
        $email = $this->email;

        if ($userNm == '' || $userPwd == '') {
            return 'Please input your user name or password';
        }

        if (strcmp($userPwd, $userPwdCfm) != 0) {
            return 'Your password does not match';
        }

        if (strcmp($email, '') != 0) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Please input a correct email";
            }
        }
        $signIn = new SignIn('user');
        $item = $signIn->search($userNm);
        $size = count($item);
        if ($size > 0) {
            return 'This username has been occupied, please choose another one.';
        }

        return '';

    }

    private function DoRegistration () {
        $userData['id'] = null;
        $userData['login_id'] = $this->userName;
        $userData['login_pwd'] = password_hash($this->userPwd, PASSWORD_DEFAULT);
        $currentTime = $this->currentTime();
        $userData['create_date'] = $currentTime;
        $userData['last_login'] = $currentTime;
        $userData['err_cnt'] = '0';
        $userData['is_locked'] = '0';
        $signIn = new SignIn('user');
        $signIn->add($userData);

        $item = $signIn->search($this->userName);
        if (count($item) > 0) {
            $this->userID = $item[0]["id"];
            $userInfo = new SignIn('user_info');
            $userInfoData['user_id'] = $this->userID;
            $userInfoData['user_firstnm'] = $this->firstName;
            $userInfoData['user_lastnm'] = $this->lastName;
            $userInfoData['user_email'] = $this->email;
            $userInfoData['user_image'] = '';
            $userInfo->add($userInfoData);
        }
        $this->setUserSession($this->userID, $this->userName);
    }
}