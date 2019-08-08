<?php


namespace app\models;

use core\base\Model;
use core\db\MyDb;
use config\Constant;

class Home extends Model
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
     * @param $title string
     * @return array returned data
     */
    public function search($sortItem, $order)
    {
        if (!isset($sortItem)) {
            $sortItem = "post_time";
        }

        if (!isset($order)) {
            $order = "desc";
        }

        $sql ="SELECT DISTINCT p.post_id, post_title, post_content, post_user_id, u.login_id
                    , post_view, post_time, ifnull(sum1.reply_cnt, 0) reply_cnt, ifnull(sum2.max_date,post_time) max_date , 
                    ifnull(u2.login_id, u.login_id) reply_user_id
                FROM post p
                    LEFT JOIN reply r ON r.post_id = p.post_id
                    INNER JOIN user u ON u.id = p.post_user_id
                    LEFT JOIN (
                        SELECT COUNT(*) AS reply_cnt, p.post_id
                        FROM reply r
                            INNER JOIN post p ON r.post_id = p.post_id
                        GROUP BY p.post_id
                    ) sum1
                    ON sum1.post_id = p.post_id
                    LEFT JOIN (
                        SELECT reply_user_id, t_reply.max_date, r.post_id
                        FROM reply r, (
                                SELECT MAX(r.reply_date) AS max_date, r.post_id
                                FROM reply r
                                    INNER JOIN post p ON r.post_id = p.post_id
                                    INNER JOIN user ui ON r.reply_user_id = ui.id
                                GROUP BY r.post_id
                            ) t_reply
                        WHERE r.post_id = t_reply.post_id
                            AND reply_date = t_reply.max_date
                    ) sum2
                    ON sum2.post_id = p.post_id
                    LEFT JOIN user u2 ON sum2.reply_user_id = u2.id
                    order by ".$sortItem." ".$order;
        $sth = MyDb::pdo()->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

}