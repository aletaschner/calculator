<?php

namespace Calculator\Models;

use Calculator\Utils\Database;

class Operation implements \JsonSerializable {
    public $id;
    public $ip;
    public $timestamp;
    public $operation;
    public $result;
    public $bonus;

    public function setIp($ip){
        $this->ip = $ip;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setOperation(string $operation){
        $this->operation = $operation;
        return $this;
    }

    public function setResult($result){
        $this->result = $result;
        return $this;
    }

    public function setBonus($bonus){
        $this->bonus = $bonus;
        return $this;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function save(){
        $query = "INSERT INTO operations (ip, timestamp, operation, result, bonus) VALUES (:ip, :timestamp, :operation, :result, :bonus)";
        Database::query($query, [
            ':ip' => ['value' => $this->ip, 'type' => \PDO::PARAM_STR], 
            ':timestamp' => ['value' => $this->timestamp, 'type' => \PDO::PARAM_INT],
            ':operation' => ['value' => $this->operation, 'type' => \PDO::PARAM_STR], 
            ':result' => ['value' => $this->result, 'type' => \PDO::PARAM_STR],
            ':bonus' => ['value' => $this->bonus, 'type' => \PDO::PARAM_INT]
        ]);
        return $this->setId(Database::getLastId());
    }

    public function jsonSerialize() {
        return [
            'result' => $this->result,
            'bonus' => $this->bonus
        ];
    }
}