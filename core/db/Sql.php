<?php
namespace core\db;

use \PDOStatement;

class Sql
{
    // table name
    protected $table;

    // primary key
    protected $primary;

    // Conditions after assembly of WHERE and ORDER
    private $filter = '';

    // Pdo bindParam() binding param array
    private $param = array();


    /**
     * Query condition splicing:
     *
     * For example: $this->where(['id = 1','and title="Web"', ...])->fetch();
     * To prevent injection, it is recommended to pass parameters through $param:
     * $this->where(['id = :id'], [':id' => $id])->fetch();
     *
     * @param array $where condition
     * @return $this current object
     */
    public function where($where = array(), $param = array())
    {
        if ($where) {
            $this->filter .= ' WHERE ';
            $this->filter .= implode(' ', $where);

            $this->param = $param;
        }

        return $this;
    }

    /**
     * Assemble the sorting conditions, using:
     *
     * $this->order(['id DESC', 'title ASC', ...])->fetch();
     *
     * @param array $order Sorting criteria
     * @return $this
     */
    public function order($order = array())
    {
        if($order) {
            $this->filter .= ' ORDER BY ';
            $this->filter .= implode(',', $order);
        }

        return $this;
    }

    // fetch all
    public function fetchAll()
    {
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->fetchAll();
    }

    // fetch one result
    public function fetch()
    {
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->fetch();
    }

    // Delete according to condition (id)
    public function delete($id, $primary)
    {

        $sql = sprintf("delete from `%s` where `%s` = :%s", $this->table, $primary, $primary);
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$primary => $id]);
        $sth->execute();

        return $sth->rowCount();
    }

    // add new record
    public function add($data)
    {
        $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));
        var_dump($sql);
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->rowCount();
    }

    public function addWithId ($data, $idName) {
        $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();
        return MyDb::pdo()->lastInsertId($idName);
    }

    // modify the data
    public function update($data)
    {
        $sql = sprintf("update `%s` set %s %s", $this->table, $this->formatUpdate($data), $this->filter);
        $sth = MyDb::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();
        return $sth->rowCount();
    }

    /**
     * Placeholders bind specific variable values
     * @param PDOStatement $sth PDOStatement object to be bound
     * @param array $params parameter, there are three types:
     * 1) If the SQL statement uses a question mark? placeholder, then $params should be
     * [$a, $b, $c]
     * 2) If the SQL statement uses a colon: placeholder, then $params should be
     * ['a' => $a, 'b' => $b, 'c' => $c]
     * or
     * [':a' => $a, ':b' => $b, ':c' => $c]
     *
     * @return PDOStatement
     */
    public function formatParam(PDOStatement $sth, $params = array())
    {
        foreach ($params as $param => &$value) {

            $param = is_int($param) ? $param + 1 : ':' . ltrim($param, ':');

            $sth->bindParam($param, $value);
        }

        return $sth;
    }

    // Convert the array to the sql statement in the insert format
    private function formatInsert($data)
    {
        $fields = array();
        $names = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $names[] = sprintf(":%s", $key);
        }

        $field = implode(',', $fields);
        $name = implode(',', $names);

        return sprintf("(%s) values (%s)", $field, $name);
    }

    // Convert an array to an updated format sql statement
    private function formatUpdate($data)
    {
        $fields = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = :%s", $key, $key);
        }

        return implode(',', $fields);
    }
}