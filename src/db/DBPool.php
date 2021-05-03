<?php

namespace db;
use \PDO, \PDOException;

class DBPool{
    private static $pdo;


    public static function getInstance() : PDO{
        if(null === self::$pdo){
            try{
                self::$pdo = new PDO("mysql:dbname=films;host=localhost;charset=utf8", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
            } catch (PDOException $e){
                var_dump($e);
                die();
            }
        }
        return self::$pdo;
    }
}