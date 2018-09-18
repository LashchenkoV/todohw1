<?php

namespace app\controllers;

use core\base\Controller;
use core\base\View;
use core\system\database\Database;
use core\system\database\DatabaseQuery;

class Main extends Controller
{
    public function action_index()
    {
//        $v = new View("main");
//        $v->text="hello main page";
//        $v->header="HELLO";
//        $v->x=[1,2,3,4,5,6];
//        $v->setTemplate();
//        echo $v->render();
        $db = Database::instance();
        echo $db->users
            ->where("age", ">", ":minAge")
            ->andWhere("age", "<", ":maxAge")
            ->andWhereGroup(function (DatabaseQuery $t) {
                $t->where("a", ">", ":a");
                $t->orWhere("b", "<", ":b");
            })
            ->asc('name')
            ->limit(20)
            ->getResult();
    }

    public function action_test()
    {
        echo "test";
    }
}