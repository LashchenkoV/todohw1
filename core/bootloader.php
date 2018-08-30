<?php

define("DOCROOT",__DIR__."/../");
define("VIEW_PATH",DOCROOT."app/views/");
define("TEMPLATES_PATH",DOCROOT."app/templates/");

require_once __DIR__."/base/Controller.php";
require_once __DIR__."/base/Model.php";
require_once __DIR__."/base/View.php";

require_once __DIR__."/system/exceptions/RouterException.php";
require_once __DIR__."/system/Route.php";
require_once __DIR__."/system/Router.php";

Router::instance()->addRoute(new Route("","main","index"));
Router::instance()->addRoute(new Route("test","main","test"));

try{
    Router::instance()->navigate();
}catch (RouterException $e){
    echo "404 NOT FOUND: ".$e->getMessage();
}






