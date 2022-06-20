<?php


namespace App\Models;


use App\BaseModel;

class Comment extends BaseModel
{
    public const TABLE = 'comments';

    public $message;
    public $post_id;
    public $user_id;
    public $created_at;

    public function getUserById(int $id) : object
    {
        $user = User::getById($id)[0];
        return $user;
    }

    public static function create($data)
    {
        $data['user_id'] = User::createOrFind($data['name'])->id;
        if ($data['name']) {
            unset($data['name']);
        }

        $now = new \DateTime();
        $data['created_at'] = $now->format('d.m.Y');

        return static::insert($data);
    }

    public static function createOrFind($data)
    {
        // To avoid duplicates
        $comments = static::getAll();
        foreach ($comments as $comment) {
            if ($comment->message === $data['message']) {
                return $comment;
            }
        }

        $data['user_id'] = User::createOrFind($data['name'])->id;
        if ($data['name']) {
            unset($data['name']);
        }

        $now = new \DateTime();
        $data['created_at'] = $now->format('d.m.Y');

        static::insert($data);

        // To avoid duplicates
        $comments = static::getAll();
        foreach ($comments as $comment) {
            if ($comment->message === $data['message']) {
                return $comment;
            }
        }
    }
}