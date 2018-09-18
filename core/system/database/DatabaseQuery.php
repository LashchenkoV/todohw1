<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 18.09.2018
 * Time: 19:38
 */

namespace core\system\database;


class DatabaseQuery
{
    private $table,$db;
    public function __construct(Database $database,string $table)
    {
        $this->db=$database;
        $this->table = $table;
        $this->comp = (object)[
            "where"=>[],
            "having"=>[],
            "order"=>[],
            "limit"=>NULL,
            "offset"=>NULL,
            "fields"=>NULL,
            "join"=>[]
        ];
    }


    private $comp;

    private static function _field($field){
        return "`".str_replace(".","`.`",$field)."`";
    }


    public function asc($field="id"){
        $this->comp->order[] = ["ASC",self::_field($field)];
        return $this;
    }

    public function desc($field="id"){
        $this->comp->order[] = ["DESC",self::_field($field)];
        return $this;
    }

    public function limit(int $limit){
        $this->comp->limit = $limit;
        return $this;
    }

    public function offset(int $offset){
        $this->comp->offset = $offset;
        return $this;
    }

    private static function _where($type,$field,$sign,$value){
        if($value===NULL){$value=$sign;$sign="=";}
        return [$type,self::_field($field),$sign,$value];
    }

    public function where($field,$sign,$value=NULL){
        $this->comp->where[] = self::_where("",$field,$sign,$value);
        return $this;
    }
    public function andWhere($field,$sign,$value=NULL){
        $this->comp->where[] = self::_where("AND",$field,$sign,$value);
        return $this;
    }
    public function orWhere($field,$sign,$value=NULL){
        $this->comp->where[] = self::_where("OR",$field,$sign,$value);
        return $this;
    }

    private function _whereGroup(callable $callback,$type){
        if($type!==NULL) $this->comp->where[]=$type;
        $this->comp->where[]="(";
        $callback($this);
        $this->comp->where[]=")";
        return $this;
    }

    public function whereGroup(callable $callback){
        return $this->_whereGroup($callback,NULL);
    }

    public function andWhereGroup(callable $callback){
        return $this->_whereGroup($callback,"AND");
    }

    public function orWhereGroup(callable $callback){
        return $this->_whereGroup($callback,"OR");
    }



    public function getResult(){
        $q = "SELECT * FROM `{$this->table}`";
        if(!empty($this->comp->where)){
            $q.=" WHERE ";
            foreach ($this->comp->where as $w){
                if(!is_array($w)) $q.=" {$w} ";
                else $q.=" {$w[0]} {$w[1]} {$w[2]} {$w[3]}";
            }
        }

        if(!empty($this->comp->order)){
            $q.=" ORDER BY ".implode(",",array_map(function ($elem){
                    return "{$elem[1]} {$elem[0]}";
                },$this->comp->order));
        }

        if($this->comp->limit!==NULL){
            $q.= " LIMIT {$this->comp->limit}";
        }
        if($this->comp->offset!==NULL){
            $q.= " OFFSET {$this->comp->offset}";
        }
        return $q;
    }




}

//$db->users
//->where("age",">",":minAge")
//->andWhere("age","<",":maxAge")
//->andWhereGroup(function($t){
//  $t->where("a",">",":a")
//  $t->orWhere("b","<",":b")
//})
//->latest('name')
//->limit(20)
//->all(["minAge"=>20,"maxAge"=>50]);