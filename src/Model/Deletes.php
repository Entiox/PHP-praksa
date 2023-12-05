<?php
namespace App\Model;

trait Deletes
{
    public static function enableDeletedAt()
    {
        self::initialize();
        self::$connection->addColumn(self::$tableName, ["deleted_at" => "TIMESTAMP NULL DEFAULT NULL"]);
    }

    public function delete()
    {
        self::$connection->delete(self::$tableName, [[self::$primaryKeyName, "=", $this->primaryKeyValue]]);
    }

    public function softDelete()
    {
        $deletedAtExists = self::$connection->checkColumn(self::$tableName, "deleted_at");
        if(!$deletedAtExists)
        {
            return;
        }
        $currentValue = self::$connection->select("SELECT deleted_at FROM ".self::$tableName." WHERE ".self::$primaryKeyName." = ".$this->primaryKeyValue)->fetchAssoc();

        if($currentValue["deleted_at"])
        {
            return;
        }
        self::$connection->update(self::$tableName, ["deleted_at" => date("Y-m-d H:i:s")], [[self::$primaryKeyName, "=", $this->primaryKeyValue]]);
    }
}
