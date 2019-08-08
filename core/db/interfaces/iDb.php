<?php
namespace core\db\interfaces;

interface iDb
{
    public function __construct($pdo);
    public static function pdo();
}