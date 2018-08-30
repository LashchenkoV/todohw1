<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 30.08.2018
 * Time: 20:18
 */

class Main extends Controller{
    public function action_index(){
        $v = new View("main");
        $v->text="hello main page";
        $v->header="HELLO";
        $v->setTemplate();
        echo $v->render();
    }
    public function action_test(){
        echo "test";
    }
}