<?php


namespace app\controllers;

use app\models\Profile;
use app\models\Post;
use core\base\Controller;

class ProfileController extends Controller
{
    // Index method
    public function index()
    {
        $this->assign('title', 'User Profile');
        $this->render();
    }
}