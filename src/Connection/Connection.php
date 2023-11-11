<?php
namespace App\Connection;

use PDO;
use PDOStatement;

class Connection
{
    private static Connection $connnection;
    private PDO $pdo;

    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=praksa", "root");
    }

    public static function getInstance()
    {
        if(!isset(self::$connnection))
        {
            self::$connnection = new Connection();
        }
        return self::$connnection;
    }

    public function select(string $query, array $values = []): PDOStatement
    {
        $sth = $this->pdo->prepare($query);
        if(array_is_list($values))
        {
            foreach($values as $key => $value)
            {
                $sth->bindValue($key + 1, $value);
            }
        }
        else
        {
            foreach($values as $key => $value)
            {   
                $sth->bindValue($key, $value);
            }
        }
        $sth->execute();
        return $sth;
    }

    public function fetchAssoc(PDOStatement $statement)
    {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(PDOStatement $statement)
    {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $tableName, array $values)
    {
        $insertSingle = function ($attrs) use ($tableName)
        {
            $query = "INSERT INTO ".$tableName." (".implode(", ", array_keys($attrs)).")
            VALUES(".implode(", ", array_map(function($attr){ return ":".$attr; }, array_keys($attrs))).")";
            $sth = $this->pdo->prepare($query); 

            foreach($attrs as $key => $attr)
            {   
                $sth->bindValue($key, $attr);
            }
            
            $sth->execute();
            return $sth;
        };

        if(is_array(reset($values)))
        {
            foreach($values as $value)
            {
                $insertSingle($value);
            }
        }
        else
        {
            $insertSingle($values);
        }
        return $this->pdo->lastInsertId();
    }

    public function update(string $tableName, array $columns, array $conditions = []): PDOStatement
    {
        $query = "UPDATE ".$tableName." SET ".implode(", ", array_map(function($key) {
            return $key." = :".$key;
        }, array_keys($columns)));

        if(count($conditions) != 0)
        {
            $query .= " WHERE ";
        }

        foreach($conditions as $index => $condition)
        {
            $query .= implode(" ", array_map(function($condIndex, $value) use($index)
            {
                if($condIndex === 2)
                {
                    return ":cond".$index;
                }
                return $value;
            }, array_keys($condition), $condition))." ";
        }

        $sth = $this->pdo->prepare($query);

        foreach($columns as $key => $column)
        {   
            $sth->bindValue($key, $column);
        }

        foreach($conditions as $index => $condition)
        {
            $sth->bindValue(":cond".$index, $condition[2]);
        }

        $sth->execute();
        return $sth;
    }
}