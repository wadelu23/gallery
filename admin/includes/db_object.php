<?php

class Db_object{

    public static function find_all(){
        $sql = "SELECT * FROM ". static::$db_table." ";
        return static::find_this_query($sql);
    }
    public static function find_by_id($user_id){
        $sql = "SELECT * FROM ".static::$db_table." WHERE id = $user_id LIMIT 1";
        $result_array = static::find_this_query($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_this_query($sql){
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = static::instantation($row);
        }
        return $the_object_array;
    }

    public static function instantation($the_record){
        $calling_class = get_called_class();
        $object = new $calling_class;

        foreach ($the_record as $the_attribute => $value) {
            if($object->has_the_attribute($the_attribute)){
                $object->$the_attribute = $value;
            }
        }
        return $object;
    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }


}