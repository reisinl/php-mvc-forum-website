<?php


namespace app\controllers;


use app\models\Func;
use core\base\Controller;

class FuncController extends Controller
{
    public function switchLan()
    {
        if(isset($_SERVER ["QUERY_STRING"])){
            $language = $_SERVER ["QUERY_STRING"];
            $_SESSION["language"] = $language;
        }
        $this->render();
    }

    public function users(){
        $items = (new Func('user'))->search();
        echo json_encode($items);
    }

    public function logout() {
        $this->unsetSession();
        $this->redirect('/login/index');
    }
}