<?php
namespace core\base;

use core\db\Sql;

class Model extends Sql
{
    protected $model;

    public function __construct()
    {
        // Get the database table name
        if (!$this->table) {

            // Get the model class name
            $this->model = get_class($this);

            // Delete the last Model character of the class name
            $this->model = substr($this->model, 0, -5);

            // Set the database table name as the same as the class name.
            $this->table = strtolower($this->model);
        }
    }
}