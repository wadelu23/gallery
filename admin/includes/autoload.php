<?php
spl_autoload_register('autoloader');

function autoloader($class){

    $class = strtolower($class);

    $the_path = "includes/{$class}.php";

    if(is_file($the_path) && !class_exists($class)){
        include($the_path);
    }

    if(file_exists($the_path)){
        include_once($the_path);
    }else{
        die("This file named {$class}.php was not found ");
    }
}


function redirect($redirect){
    header("Location: {$redirect}");
}