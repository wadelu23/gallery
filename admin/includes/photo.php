<?php

class Photo extends Db_object{
    protected static $db_table = "photos";
    protected static $db_table_fields = array('photo_id','title','description','filename','type','size');
    public $photo_id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

    public $tmp_path;
    public $upload_directory = "images";
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

    //passing $_FILES['upload_file'] as a argument
    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)){
            $this->aErrors[] = "There was no file uploaded here";
            return false;
        }elseif($file['error'] != 0){
            $this->aErrors[] = $this->aUpload_errors[$file['error']];
            return false;
        }else{
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }

    }

    public function picture_path(){
        return $this->upload_directory.DS.$this->filename;
    }

    public function save(){
        if($this->photo_id){
            $this->update();
        }else{
            if(!empty($this->aErrors)){return false;}
            if(empty($this->filename || empty($this->tmp_path))){
                $this->aErrors[] = "the file was not avaiable";
                return false;
            }
            $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->filename;
            if(file_exists($target_path)){
                $this->aErrors[] = "The file {$this->filename} already exist";
                return false;
            }
            if(move_uploaded_file($this->tmp_path,$target_path)){
                if($this->create()){
                    unset($this->tmp_path);
                    return true;
                }
            }else{
                $this->aErrors[] = "the file directory probably does not have permission";
                return false;
            }
        }
    }
}