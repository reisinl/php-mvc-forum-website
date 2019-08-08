<?php
namespace core\base;

use core\interfaces\iAssign;
use core\interfaces\iRender;

/**
 * Controller base class
 */
class Controller implements iRender, iAssign
{
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $_userName;

    // Constructor, initialize properties, and instantiate the corresponding model
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    // Assign variable
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    // Render view
    public function render()
    {
        $this->_view->render();
    }

    public function redirect($url)
    {
        header("Location:".$url);
    }

    public function setUserSession ($userID, $userName) {
        $_SESSION['user_name'] = $userName;
        $_SESSION['user_id'] = $userID;
    }

    public function currentTime () {
        return date('Y-m-d H:i:s');
    }

    public function loginUserName () {
        if (isset($_SESSION['user_name'])) {
            return $_SESSION['user_name'];
        }
        return "";
    }

    public function loginUserID() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }
        return "";
    }

    public function unsetSession () {
        session_unset();
        session_destroy();
    }
}