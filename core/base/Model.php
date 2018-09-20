<?php
namespace core\base;
use core\system\database\Database;
use core\system\database\DatabaseQuery;

abstract class Model
{
    protected $db;


    public function __construct()
    {
        $this->db = Database::instance();
    }

    public static function __callStatic($name, $arguments)
    {
        $Clazz= get_called_class();
        if(!empty($Clazz::$table)){
            $table = $Clazz::$table;
        }else{
            $parts = explode("\\",$Clazz);
            $table = strtolower(end($parts))."s";
        }
        return call_user_func_array([Database::instance()->$table, $name], $arguments);
    }


}