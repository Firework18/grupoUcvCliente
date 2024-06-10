<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost','root','pikachu18','grupoweb');

    if(!$db){
        echo "Error no se pudo ejecutar";
        
        exit;
    }
    return $db;
}