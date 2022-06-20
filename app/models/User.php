<?php

namespace App\Models;

use App\BaseModel;
use App\Db;

class User extends BaseModel
{
    public const TABLE = 'users';

    public $name;

    public static function getByName($name)
    {
        $db = new Db();
        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE name=:name';
        return $db->query($sql, static::class, [':name' => $name])[0];
    }

    public static function createOrFind($name)
    {
        // To avoid duplicates
        $users = static::getAll();
        foreach ($users as $user) {
            if ($user->name === $name) {
                return $user;
            }
        }

        $data = [];
        $data['name'] = $name;

        static::insert($data);

        // To avoid duplicates
        $users = static::getAll();
        foreach ($users as $user) {
            if ($user->name === $name) {
                return $user;
            }
        }
    }
}