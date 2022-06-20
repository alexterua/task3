<?php

namespace App\Models;

use App\BaseModel;
use App\Db;

class Rating extends BaseModel
{
    public const TABLE = 'ratings';

    public $grade;
    public $post_id;
    public $user_id;

    public static function getSummaryGradeForIdentityPostId()
    {
        $db = new Db();
        $sql = 'SELECT SUM(grade) as grades, post_id FROM ' . static::TABLE . ' GROUP BY post_id';
        return $db->query($sql, static::class);
    }

    public static function countRowsForPostId(int $post_id)
    {
        $data = [];
        $data['post_id'] = $post_id;
        $db = new Db();
        $sql = 'SELECT COUNT(post_id) as post_id FROM ' . static::TABLE . ' WHERE post_id=:post_id';
        return $db->query($sql, static::class, $data)[0];
    }

    public static function create($data)
    {
        if ($data['name'] === '') {
            $randomName = generateRandomString();
            $data['user_id'] = User::createOrFind($randomName)->id;
            $_SESSION['name'] = $randomName;
        }

        if (isset($_SESSION['name'])) {
            $data['user_id'] = User::createOrFind($_SESSION['name'])->id;
        }

        unset($data['name']);

        static::insert($data);
    }

    public static function getByUserId(int $user_id)
    {
        $db = new Db();
        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE user_id=:user_id';
        return $db->query($sql, static::class, [':user_id' => $user_id]);
    }
}