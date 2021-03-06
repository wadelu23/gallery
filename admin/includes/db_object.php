<?php

class Db_object{

    public $aErrors = array();
    public $aUpload_errors = array(
        UPLOAD_ERR_OK           => "no Error",
        UPLOAD_ERR_INI_SIZE     => "upload_max_file",
        UPLOAD_ERR_FORM_SIZE    => "max_file_size",
        UPLOAD_ERR_PARTIAL      => "only partially upload",
        UPLOAD_ERR_NO_FILE      => "NO FILE",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload",
    );

    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)){
            $this->aErrors[] = "There was no file uploaded here";
            return false;
        }elseif($file['error'] != 0){
            $this->aErrors[] = $this->aUpload_errors[$file['error']];
            return false;
        }else{
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }
    }

    public static function find_all(){
        $sql = "SELECT * FROM ". static::$db_table." ";
        return static::find_by_query($sql);
    }
    public static function find_by_id($id){
        $sql = "SELECT * FROM ".static::$db_table." WHERE id = $id LIMIT 1";
        $result_array = static::find_by_query($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_query($sql){
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

    protected function properties(){
        $properties = array();
        foreach (static::$db_table_fields as $db_fields) {
            if(property_exists($this, $db_fields)){
                $properties[$db_fields] = $this->$db_fields;
            }
        }
        return $properties;
    }

    protected function clean_properties(){
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }



    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }


    public function create(){
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO `".static::$db_table."` (".implode(",",array_keys($properties)).")";
        $sql .= "VALUES ('".implode("','",array_values($properties))."')";

        if($database->query($sql)){
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }//Create Method

    public function update(){
        global $database;

        $properties = $this->clean_properties();
        $properties_pairs = array();
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "`{$key}`='{$value}'";
        }

        $sql = "UPDATE `".static::$db_table."` SET";
        $sql .= implode(", ",$properties_pairs);
        $sql .= " WHERE `id`=".$database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }//Update Method
    
    public function delete(){
        global $database;
        $sql = "DELETE FROM `" .static::$db_table. "` ";
        $sql .= " WHERE id = ".$database->escape_string($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }//Delete Method

    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }




}