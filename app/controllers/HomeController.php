<?php


namespace app\controllers;


use app\models\Home;
use core\base\Controller;
use core\interfaces\iController;

class HomeController extends Controller implements iController
{
    protected $_sortItem;
    protected $_order;
    public function Index () {

        $items = (new Home('')) ->search($this->_sortItem, $this->_order);
        //var_dump($items[0]);
        $this->assign('title', 'Home');
        $this->assign('posts', $items);
        $this->assign('item', $this->_sortItem);
        $this->assign('order', $this->_order);
        $this->assign('userName', $_SESSION['user_name']);
        $this->render();
    }

    public function Order () {
        if(isset($_SERVER ["QUERY_STRING"])){
            $parm = explode("&", $_SERVER ["QUERY_STRING"]) ;
            $this->_order = $parm[0];
            $this->_sortItem = $parm[1];

        }
        parent::__construct($this->_controller, "index");
        $this->Index();
    }
}