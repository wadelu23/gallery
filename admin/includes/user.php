<?php

class User {

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all_users(){
        $sql = "SELECT * FROM users";
        return self::find_this_query($sql);
    }
    public static function find_user_by_id($user_id){
        $sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
        $result_array = self::find_this_query($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_this_query($sql){
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = self::instantation($row);
        }
        return $the_object_array;
    }

    public static function verify_user($username,$password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE";
        $sql .= "`username` = '{$username}'";
        $sql .= "AND `password` = '{$password}'";
        $sql .= "LIMIT 1";

        $result_array = self::find_this_query($sql);
        
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function instantation($the_record){

        $object = new self;

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