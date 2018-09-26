<?php

namespace app\controllers;

use app\models\Note;
use core\base\Controller;
use core\base\View;
use core\system\database\Database;
use core\system\database\DatabaseQuery;

class Main extends Controller
{
    public function action_index()
    {
        $tableNotes = new View("tableNotes");
        $tableNotes->notes = Note::all();
        $tableNotes->setTemplate();
        echo $tableNotes->render();
    }

    public function action_getEditForm(){
        if(empty(@$_POST['id'])){
            echo json_encode(["status"=>0]);
            return;
        }
        $editForm = new View("editForm");
        $editForm->note = Note::where("id",$_POST['id'])->all();
        echo $editForm->render();
    }
    public function action_getTableNotes()
    {
        $tableNotes = new View("tableNotes");
        $tableNotes->notes = Note::all();
        echo $tableNotes->render();
    }
    public function action_delNote(){
        if(!empty(@$_POST['id'])){
            Note::where("id",$_POST['id'])->delete();
            echo json_encode(["status"=>1]);
        }
        else echo json_encode(["status"=>0]);
    }
    public function action_editNote(){
        if(!empty(@$_POST['title']) && !empty(@$_POST['message']) && !empty(@$_POST['id'])){
            Note::where("id",$_POST['id'])->update([
                "title"=>$_POST['title'],
                "text"=>$_POST['message'],
                "date"=>time()
            ]);
            echo json_encode(["status"=>1]);
        }else{
            $err = '';
            if(empty(@$_POST['title']))
                $err .= "Неверный заголовок";
            if(empty(@$_POST['message']))
                $err .= " Неверноый текст";

            echo json_encode(["status"=>0,"err"=>$err]);
        }
    }
    public function action_addTodo()
    {
        if(!empty(@$_POST['title']) && !empty(@$_POST['message'])){
            $model = new Note();
            $id = $model->addNote([
                "title"=>$_POST['title'],
                "text"=>$_POST['message'],
                "date"=>time()
            ]);
            echo $id>0?json_encode(["status"=>1,"id"=>$id]):json_encode(["status"=>0]);
        }else{
            echo json_encode(["status"=>0]);
        }
    }
}