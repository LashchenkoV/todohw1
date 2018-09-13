<?php

namespace app\controllers;
use core\base\Controller;
use core\base\View;

class Main extends Controller{
    public function action_index(){
        $v = new View("main");
        $v->text="hello main page";
        $v->header="HELLO";
        $v->x=[1,2,3,4,5,6];
        $v->setTemplate();
        echo $v->render();
    }
    public function action_test(){
        echo "test";
    }
}