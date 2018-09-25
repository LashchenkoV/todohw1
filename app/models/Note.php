<?php
/**
 * Created by PhpStorm.
 * Note: mamedov
 * Date: 20.09.2018
 * Time: 20:34
 */

namespace app\models;


use core\base\Model;

class Note extends Model
{
    public function addNote(array $data){
        return self::insert($data);
    }
}