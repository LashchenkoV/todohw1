<?php

class Router
{
    private static $inst=null;

    public static function instance(){
        return self::$inst!==null? self::$inst : self::$inst=new self();
    }
    private function __construct(){}


    private $routes = [];

    public function addRoute(Route $route){
        $this->routes[] = $route;
    }

    public function navigate(){
        foreach ($this->routes as $route){
            if($route->compareRoute()){
                $this->_navigate($route->getController(),$route->getAction());
                return;
            }
        }
        throw new RouterException("route not found");
    }

    private function _navigate($controller,$action){
        $ctrl_class_name = ucfirst(strtolower($controller));
        $action_name = "action_".strtolower($action);

        $ctrl_path = DOCROOT."app/controllers/".$ctrl_class_name.".php";

        if(!file_exists($ctrl_path)) throw new RouterException("controller not found");
        include_once $ctrl_path;

        $ctrl = new $ctrl_class_name();
        if(!method_exists($ctrl,$action_name)) throw new RouterException("action not found");

        $ctrl->$action_name();

    }

}