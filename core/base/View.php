<?php
namespace core\base;

use core\interfaces\iAssign;
use core\interfaces\iRender;

/**
 * View base class
 */
class View implements iAssign, iRender
{
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }
 
    // Allocation variable
    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }
 
    // Rendering the view
    public function render()
    {
        extract($this->variables);
        $defaultHeader = APP_PATH . 'app/views/template/header.php';
        $defaultFooter = APP_PATH . 'app/views/template/footer.php';

        $controllerHeader = APP_PATH . 'app/views/' . $this->_controller . '/header.php';
        $controllerFooter = APP_PATH . 'app/views/' . $this->_controller . '/footer.php';
        $controllerLayout = APP_PATH . 'app/views/' . $this->_controller . '/' . $this->_action . '.php';


        //var_dump($controllerLayout);
        //Check if the view file exists
        if (is_file($controllerLayout)) {

            // Header file
            if (is_file($controllerHeader)) {
                include ($controllerHeader);
            } else {
                include ($defaultHeader);
            }

            include ($controllerLayout);
            // Footer file
            if (is_file($controllerFooter)) {
                include ($controllerFooter);
            } else {
                include ($defaultFooter);
            }
        } else {
            include (APP_PATH . 'app/views/unfound/unfound.php');
        }
        //include (APP_PATH . 'app/core/common/Common.php');
    }
}
