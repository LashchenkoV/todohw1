<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 30.08.2018
 * Time: 19:41
 */

class View
{
    private $path;
    private $template_path=null;

    private $params =[];

    public function __set($name,$value){
        $this->params[$name]=$value;
    }

    public function __construct(string $name){
        $this->path = VIEW_PATH.$name.".php";
    }

    private function _render(){
        ob_start();
        extract($this->params);
        include $this->path;
        return ob_get_clean();
    }
    private function _renderTemplate(){
        ob_start();
        extract($this->params);
        $content = $this->_render();
        include $this->template_path;
        return ob_get_clean();
    }


    public function render(){
        return $this->template_path===null
            ?$this->_render()
            :$this->_renderTemplate();
    }

    public function setTemplate($name = "default"){
        $this->template_path = TEMPLATES_PATH.$name.".php";
    }


}