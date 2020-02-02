<?php

class User extends Db_object{
    protected static $db_table = "users";
    protected static $db_table_fields = array('username','password','first_name','last_name','user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image";
    



    public function upload_photo(){
       
        if(!empty($this->aErrors)){return false;}
        if(empty($this->user_image) || empty($this->tmp_path)){
            $this->aErrors[] = "the file was not avaiable";
            return false;
        }
        $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->user_image;
        if(file_exists($target_path)){
            $this->aErrors[] = "The file {$this->user_image} already exist";
            return false;
        }
        if(move_uploaded_file($this->tmp_path,$target_path)){
            unset($this->tmp_path);
            return true;
        }else{
            $this->aErrors[] = "the file directory probably does not have permission";
            return false;
        }
    }

    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
    }


    public static function verify_user($username,$password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM ". self::$db_table." WHERE";
        $sql .= "`username` = '{$username}'";
        $sql .= "AND `password` = '{$password}'";
        $sql .= "LIMIT 1";

        $result_array = self::find_by_query($sql);
        
        return !empty($result_array) ? array_shift($result_array) : false;
    }



}//End of Class User