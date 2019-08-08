<?php
namespace core\db;

use core\db\interfaces\iDb;
use PDO;
use PDOException;

/**
 * Database operation class
 * The $PDO property is a static property, so during the page execution cycle,
 * as long as the assignment is made once, the subsequent acquisition is still the first assignment.
 * this is the PDO object, which ensures that there is only one during runtime
 * database connection object, this is a simple singleton pattern
 */
class MyDb implements iDb
{
    private static $pdo = null;

    public function __construct($pdo)
    {
        parent::__construct($pdo);
    }

    public static function pdo()
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        try {
            $dsn    = sprintf('mysql:host=%s;dbname=%s;charset=utf8', DB_HOST, DB_NAME);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            return self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $option);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}