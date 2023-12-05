<?php
namespace App\Connection;

use PDO;
use PDOStatement;

class Connection
{
    private static Connection $connnection;
    private PDO $pdo;
    private PDOStatement $sth;

    private function __construct()
    {
        $this->pdo = new PDO($_ENV["DB_DNS"], $_ENV["DB_USERNAME"]);
    }

    public static function getInstance()
    {
        if(!isset(self::$connnection)) {
            self::$connnection = new Connection();
        }
        return self::$connnection;
    }

    public function select(string $query, array $values = [])
    {
        $this->sth = $this->pdo->prepare($query);
        if(array_is_list($values)) {
            foreach($values as $key => $value) {
                $this->sth->bindValue($key + 1, $value);
            }
        } else {
            foreach($values as $key => $value) {   
                $this->sth->bindValue($key, $value);
            }
        }
        $this->sth->execute();
        return $this;
    }

    public function fetchAssoc()
    {
        return $this->sth->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll()
    {
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkColumn($tableName, $columnName)
    {
        $this->sth = $this->pdo->prepare("SHOW COLUMNS FROM ".$tableName." WHERE Field LIKE '".$columnName."'");
        $this->sth->execute();
        return $this->fetchAssoc();
    }

    public function insert(string $tableName, array $values)
    {
        $insertSingle = function ($attrs) use ($tableName)
        {
            $query = "INSERT INTO ".$tableName." (".implode(", ", array_keys($attrs)).")
            VALUES(".implode(", ", array_map(function($attr) { return ":".$attr; }, array_keys($attrs))).")";
            $this->sth = $this->pdo->prepare($query); 

            foreach($attrs as $key => $attr) {   
                $this->sth->bindValue($key, $attr);
            }
            
            $this->sth->execute();
            return $this->sth;
        };

        if(is_array(reset($values))) {
            foreach($values as $value) {
                $insertSingle($value);
            }
        }
        else
        {
            $insertSingle($values);
        }
        return $this->pdo->lastInsertId();
    }

    public function update(string $tableName, array $columns = [], array $conditions = [])
    {
        $query = "UPDATE ".$tableName." SET ".implode(", ", array_map(function($key) {
            return $key." = :".$key;
        }, array_keys($columns)));

        if(count($conditions) != 0) {
            $query .= " WHERE ";
        }

        foreach($conditions as $index => $condition) {
            $query .= implode(" ", array_map(function($condIndex, $value) use($index) {
                if($condIndex === 2) {
                    return ":cond".$index;
                }
                return $value;
            }, array_keys($condition), $condition))." ";
        }

        $this->sth = $this->pdo->prepare($query);

        foreach($columns as $key => $column) {   
            $this->sth->bindValue($key, $column);
        }

        foreach($conditions as $index => $condition) {
            $this->sth->bindValue("cond".$index, $condition[2]);
        }

        $this->sth->execute();
    }

    public function addColumn(string $tableName, array $values)
    {
        $query = "ALTER TABLE ".$tableName." ".implode(", ", array_map(function($key, $value) {
            return "ADD COLUMN IF NOT EXISTS ".$key." ".$value;
        }, array_keys($values), $values));
        $this->sth = $this->pdo->prepare($query);
        $this->sth->execute();
    }

    public function delete(string $tableName, array $conditions = [])
    {
        $query = "DELETE FROM ".$tableName;
        
        if(count($conditions) != 0) {
            $query .= " WHERE ";
        }

        foreach($conditions as $index => $condition) {
            $query .= implode(" ", array_map(function($condIndex, $value) use ($index) {
                if($condIndex === 2) {
                    return ":cond".$index;
                }
                return $value;
            }, array_keys($condition), $condition))." ";
        }

        $this->sth = $this->pdo->prepare($query);

        foreach($conditions as $index => $condition) {
            $this->sth->bindValue("cond".$index, $condition[2]);
        }
        $this->sth->execute();
    }
}
