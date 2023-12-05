<?php
namespace App\Model;

trait HasTimestamps
{
    public static function enableTimestamps()
    {
        self::initialize();
        self::$connection->addColumn(self::$tableName, ["created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
            "updated_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"]);
    }
}
