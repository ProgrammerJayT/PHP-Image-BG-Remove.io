<?php

class Model extends Database {

    public $errors = array();

    public function __construct(){

        if (!property_exists($this, 'table')){
            $this->table = strtolower(get_class($this));
        }
    }

    public function where($column, $value){

        $column = addslashes($column);

        $query = "select * from $this->table where $column = :value";
        return $this->query($query, [
            'value'=> $value
        ]);
    }

    public function findAll(){

        $query = "select * from $this->table";
        return $this->query($query);
    }

    public function insert($data){

        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $values = implode(',:', $keys);

        $query = "insert into $this->table ($columns) values(:$values)";
        return $this->query($query, $data);
    }

    public function update($id, $data){

        $str = "";
        foreach ($data as $key => $value) {
            $str .= $key. "=:". $key. ",";
        }

        $str = trim($str, ",");

        $data['id'] = $id;
        $query = "update $this->table set $str where id = :id";

        return $this->query($query, $data);
    }
}