<?php
declare(strict_types=1);

namespace School;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;

class SchoolClass
{   
    public int $code = 0;
    public string $name = '';
    
    public function __construct(int $code = 0,string $name = '')
    {
        $this->code = $code;
        $this->name = $name;
    }

    public static function getByCode($code = null): SchoolClass
    {
        $adapter = self::getAdapter();
        
        $qi = function ($name) use ($adapter) {
            return $adapter->platform->quoteIdentifier($name);
        };        
        $fp = function ($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $statement = $adapter->query('SELECT * from classes WHERE ' . $qi('code') . '=' . $fp('code'));
        $resultSet = $statement->execute(['code' => $code]);
        if ($resultSet->count() == 0){
            return new SchoolClass();
        }
        $row = $resultSet->current();
        return new SchoolClass((int)$row['code'],$row['name']);
    }
    
    public static function getByName($name = null): SchoolClass
    {
        $adapter = self::getAdapter();
        
        $qi = function ($name) use ($adapter) {
            return $adapter->platform->quoteIdentifier($name);
        };
        $fp = function ($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $statement = $adapter->query('SELECT * from classes WHERE ' . $qi('name') . '=' . $fp('name'));
        $resultSet = $statement->execute(['name' => $name]);
        if ($resultSet->count() == 0){
            return new SchoolClass();
        }
        $row = $resultSet->current();
        return new SchoolClass((int)$row['code'],$row['name']);
    }
    
    public static function getAll(): iterable
    {
        $adapter = self::getAdapter();
        $statement = $adapter->query('SELECT * from classes');
        $resultSet = $statement->execute();
        return $resultSet;
    }
    
    public function save(): bool
    {
        $adapter = self::getAdapter();
        
        $fp = function ($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        if (empty($this->code)){
            $statement = $adapter->query('INSERT INTO classes(name) VALUES (' . $fp('name') . ')');
            $params = ['name' => $this->name];
        } else {
            $statement = $adapter->query('UPDATE classes SET name=' . $fp('name') . ' WHERE code=' . $fp('code'));
            $params = [
                'code' => $this->code,
                'name' => $this->name
            ];
        }
        try {
            $statement->execute($params);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
    public function delete(): bool
    {
        $adapter = self::getAdapter();
        
        $fp = function ($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $statement = $adapter->query('DELETE FROM classes WHERE code=' . $fp('code'));
        try {
            $statement->execute([
                'code' => $this->code
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
    private static function getAdapter(): AdapterInterface
    {
        $config = require (realpath(__DIR__ . '/../config') . '/config.php');
        $adapter = new Adapter($config['db']);
        return $adapter;
    }    
}

