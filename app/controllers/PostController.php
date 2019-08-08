<?php


namespace app\controllers;


use app\models\Home;
use app\models\Post;
use core\base\Controller;
use core\interfaces\iController;

class PostController extends Controller implements iController
{
    protected $_postTitle;
    protected $_postContent;
    protected $_postID;
    public function Index () {

        $this->assign('title', 'Make a post');
        $this->assign('userName', $_SESSION['user_name']);
        $this->render();
    }

    public function Add() {
        $this->_postTitle = $_POST['post_title'];
        $this->_postContent = $_POST['post_content'];

        $postData['post_id'] = null;
        $postData['post_title'] = $this->_postTitle;
        $postData['post_content'] = $this->_postContent;
        $postData['post_attach'] = null;
        $postData['post_user_id'] = $_SESSION['user_id'];

        $postData['post_time'] = $this->currentTime();
        $postData['post_view'] = '0';
        $postData['post_like'] = '0';
        $postData['post_dislike'] = '0';
        $this->_postID = (new Post('post'))->addWithId($postData, 'post_id');

        $this->redirect('/post/detail?'.$this->_postID);
    }

    public function Detail() {

        if(isset($_SERVER ["QUERY_STRING"])){
            $this->_postID = $_SERVER ["QUERY_STRING"];
        }

        $model = new Post('post');
        $post = $model->searchPost($this->_postID);
        $comments = $model->searchComment($this->_postID);
        $this->assign('title', 'Post Detail');
        // update the view of the post
        $postView = $post[0]['post_view'] + 1;
        $postData = array('post_id' => $this->_postID, 'post_view' => $postView);
        $model->where(['post_id = :post_id'], [':post_id' => $postData['post_id']])->update($postData);

        $this->assign('post', $post[0]);
        $this->assign('comments', $comments);
        $this->assign('userName', $this->loginUserName());
        $this->render();

    }

    public function Reply() {

        $comment = $_POST['comment'];
        $postID = $_POST['post_id'];
        $postData['reply_id'] = null;
        $postData['post_id'] = $postID;
        $postData['reply_user_id'] = $this->loginUserID();
        $postData['reply_content'] = $comment;
        $postData['reply_date'] = $this->currentTime();
        $postData['reply_attach'] = "";
        var_dump($postData);

        (new Post('reply'))->add($postData);

        $this->redirect('/post/detail?'.$postID);

    }

    public function Edit() {

        if(isset($_SERVER ["QUERY_STRING"])){
            $this->_postID = $_SERVER ["QUERY_STRING"];
        }

        $this->assign('title', 'Edit a post');
        $model = new Post('post');
        $post = $model->searchPost($this->_postID);
        $this->assign('post', $post[0]);
        $this->assign('userName', $this->loginUserName());
        $this->render();
    }

    public function doEdit() {

        $content = $_POST['post_content'];
        $title = $_POST['post_title'];
        $postID = $_POST['post_id'];

        $model = new Post('post');
        $postData = array('post_id' => $postID, 'post_content' => $content, 'post_title' => $title);
        $model->where(['post_id = :post_id'], [':post_id' => $postData['post_id']])->update($postData);

        $this->redirect('/post/detail?'.$postID);
    }

    public function Delete() {

        if(isset($_SERVER ["QUERY_STRING"])){
            $this->_postID = $_SERVER ["QUERY_STRING"];
        }

        $model = new Post('reply');

        $model->delete($this->_postID, 'post_id');

        $model = new Post('post');
        $model->delete($this->_postID, 'post_id');

        $this->redirect('/home/index');
    }
}