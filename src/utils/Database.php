<?php

namespace Calculator\Utils;

 class Database {

    public static function connect(){
        return new \PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }

    public static function query(string $query, $params = []){
        $pdo = static::connect();
        $prep = $pdo->prepare($query);
        if(count($params) > 0){
            foreach($params as $k => $param){
                if(is_array($param))
                    $prep->bindParam($k, $param['value'], $param['type']);
                else
                    $prep->bindParam($k, $param);
            }
        }

        $result = $prep->execute();
    }

    public static function getLastId(){
        $pdo = static::connect();
        return $pdo->lastInsertId();
    }
}