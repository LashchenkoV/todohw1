<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 30.08.2018
 * Time: 19:45
 */

class Route
{
    private $rule;
    private $controller;
    private $action;


    public function __construct(string $rule,string $controller,string $action){
        $this->rule = $rule;
        $this->controller = $controller;
        $this->action = $action;
    }


    private function getPath(){
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("?",$url)[0];
        return trim($url,"/");
    }
    private function getClearRule(){
        return trim($this->rule,"/");
    }

    public function compareRoute(){
        return $this->getClearRule() === $this->getPath();
    }


    public function getController(): string{
        return $this->controller;
    }


    public function getAction(): string{
        return $this->action;
    }


}