<?php


namespace app\models;

use core\base\Model;
use core\db\MyDb;

/**
 * 用户Model
 */
class Post extends Model
{

    /**
     * Customize the database table name for the current model operation,
     * If not specified, the default is a lowercase string of the class name,
     * Here is the item table
     * @var string
     */
    public function __construct($_table)
    {
        $this->table = $_table;
    }

    /**
     * Search function, because there is no ready-like search in the Sql parent class,
     * So you need to write the SQL statement yourself, the operation of the database should be put
     * Inside the Model, then provide a direct call to the Controller
     * @param $postID string
     * @return array returned data
     */
    public function search($sql, $postID)
    {
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [':postID' => $postID]);
        //var_dump($sth);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function searchPost ($postID) {
        $sql = "SELECT p.post_id, p.post_title, p.post_content, p.post_attach, p.post_user_id, ifnull(p.post_view, 0) post_view
                    , p.post_time, p.post_like, post_dislike, u.login_id, u.create_date
                FROM post p, user u
                WHERE p.post_user_id = u.id
                    AND p.post_id = :postID";
        return $this->search($sql, $postID);
    }

    public function searchComment ($postID) {
        $sql = "SELECT rp.reply_id, rp.reply_user_id, rp.reply_content, rp.reply_date, rp.reply_attach
                    , u.login_id, u.create_date
                FROM reply rp, user u
                WHERE rp.reply_user_id = u.id
                    AND rp.post_id = :postID";
        return $this->search($sql, $postID);
    }
}