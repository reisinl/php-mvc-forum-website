<?php


namespace app\models;

use core\base\Model;
use core\db\MyDb;
use config\Constant;

class Func extends Model
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
    public function search()
    {
        $sql = "select login_id name from `$this->table`";
        $sth = MyDb::pdo()->prepare($sql);
        //var_dump($sth);
        $sth->execute();

        return $sth->fetchAll();
    }

}