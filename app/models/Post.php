<?php

namespace App\Models;

use App\BaseModel;
use App\Db;

class Post extends BaseModel
{
    public const TABLE = 'posts';

    public $content;
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
        $posts = static::getAll();
        foreach ($posts as $post) {
            if ($post->content === $data['content']) {
                return $post;
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
        $posts = static::getAll();
        foreach ($posts as $post) {
            if ($post->content === $data['content']) {
                return $post;
            }
        }
    }

    public function isExistRate()
    {

        $arrayResultSummGrades = Rating::getSummaryGradeForIdentityPostId();

        foreach ($arrayResultSummGrades as $resultSummGrades) {
            if ($resultSummGrades->post_id === $this->id) {
                if (isset ($_SESSION['name']) || isset($_SESSION['user_id'])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getRating() : int
    {
        $result = 0;
        $arrayResultSummGrades = Rating::getSummaryGradeForIdentityPostId();

        foreach ($arrayResultSummGrades as $resultSummGrades) {
                if ($this->id === $resultSummGrades->post_id) {
                    $countId = Rating::countRowsForPostId($this->id);
                    $result = round($resultSummGrades->grades / $countId->post_id);
                }
        }

        return $result;
    }

    public function getRatingFromUser()
    {
        if (isset($_SESSION['name'])) {
            $user_id = User::getByName($_SESSION['name'])->id;
            $result = 0;

            $arrayGradesForCurrentUser = Rating::getByUserId($user_id);
            foreach ($arrayGradesForCurrentUser as $gradeForCurrentUser) {
                if ($this->id === $gradeForCurrentUser->post_id) {
                    $result = $gradeForCurrentUser->grade;
                }
            }

            return $result;
        } else {
            return false;
        }

    }

}