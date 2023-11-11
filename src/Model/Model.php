<?php
namespace App\Model;

use App\Connection\Connection;
use Doctrine\Inflector\Rules\English\InflectorFactory;
use ReflectionClass;

class Model
{
    private static ?Connection $connection = null;
    private static ?string $tableName = null;
    private static ?string $primaryKeyName = null;

    public function __construct(private array $attrs = [], private $primaryKeyValue = null) {
        self::initialize();
    }

    private static function initialize()
    {
        if(self::$tableName === null)
        {
            $reflection = new ReflectionClass(__CLASS__);
            $className = $reflection->getShortName();
            $inflectorFactory = new InflectorFactory();
            $inflector = $inflectorFactory->build();
            self::$tableName = strtolower($inflector->pluralize($className));
        }

        if(self::$connection === null)
        {
            self::$connection = Connection::getInstance();
        }

        if(self::$primaryKeyName === null)
        {
            $keys = self::$connection->fetchAssoc(self::$connection->select("SHOW KEYS FROM ".self::$tableName." WHERE key_name = 'PRIMARY'"));
            self::$primaryKeyName = $keys["Column_name"];
        }
    }

    public function __set($name, $value)
    {
        $this->attrs[$name] = $value;
    }

    public function __get($name)
    {
        if(isset($this->attrs[$name])){
            return $this->attrs[$name];
        }
        else
        {
            return null;
        }
    }

    public function save()
    {
        $this->primaryKeyValue = self::$connection->insert(self::$tableName, $this->attrs);
        $keys = self::$connection->fetchAssoc(self::$connection->select("SHOW KEYS FROM ".self::$tableName." WHERE key_name = 'PRIMARY'"));
        self::$primaryKeyName = $keys["Column_name"];
    }

    public function update()
    {
        if(!isset($this->primaryKeyValue))
        {
            return;
        }
        self::$connection->update(self::$tableName, $this->attrs, [[self::$primaryKeyName, "=", $this->primaryKeyValue]]);
    }

    public static function find($primaryKey)
    {
        self::initialize();
        $sth = self::$connection->select("SELECT * FROM ".self::$tableName." WHERE ".self::$primaryKeyName." = ?", [$primaryKey]);
        $attrs = self::$connection->fetchAssoc($sth);
        if($attrs === false)
        {
            return null;
        }
        unset($attrs[self::$primaryKeyName]);
        return new static($attrs, $primaryKey);
    }

    public function toArray(): array
    {
        return $this->attrs;
    }
}

