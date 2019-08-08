<?php


namespace app\models;

use core\base\Model;
use core\db\MyDb;
use config\Constant;

class Login extends Model
{
    /**
     * Customize the database table name for the current model operation,
     * If not specified, the default is a lowercase string of the class name,
     * Here is the item table
     * @var string
     */
    protected $table = 'user';


    /**
     * Search function, because there is no ready-like search in the Sql parent class,
     * So you need to write the SQL statement yourself, the operation of the database should be put
     * Inside the Model, then provide a direct call to the Controller
     * @param $title string
     * @return array returned data
     */
    public function search($userID)
    {
        $sql = "select id, login_id, login_pwd from `$this->table` where login_id = :userID order by create_date desc";
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [':userID' => "$userID"]);
        //var_dump($sth);
        $sth->execute();

        return $sth->fetchAll();
    }
}