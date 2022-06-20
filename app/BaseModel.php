<?php


namespace App;


abstract class BaseModel
{
    public const TABLE = '';

    public $id;

    public static function getAll()
    {
        $db = new Db();
        $sql = 'SELECT * FROM ' . static::TABLE;
        return $db->query($sql, static::class);
    }

    public static function getById(int $id)
    {
        $db = new Db();
        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';
        return $db->query($sql, static::class, [':id' => $id]);
    }

    public static function insert(array $fields)
    {
        $columns = [];
        $data = [];

        foreach ($fields as $name => $value) {
            $columns[] = $name;
            $data[':' . $name] = $value;
        }

        $sql = 'INSERT IGNORE INTO ' . static::TABLE . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', array_keys($data)) . ')';
        $db = new Db();
        return $db->query($sql, static::class, $data);
    }
}