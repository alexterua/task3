<?php

namespace App\Models;

class Counter
{
    public $posts = [];
    public $ratings = [];

    public function __construct(array $posts, array $ratings)
    {
        $this->posts = $posts;
        $this->ratings = $ratings;
    }

    private function getCountAllPosts() : int
    {
        $count = 0;
        foreach ($this->posts as $post) {
            $count++;
        }
        return $count;
    }

    private function getCountNegativePosts() : int
    {
        $count = 0;

        $arrayResultSummGrades = Rating::getSummaryGradeForIdentityPostId();

        foreach ($arrayResultSummGrades as $resultSummGrades) {
            foreach ($this->posts as $post) {
                if ($post->id === $resultSummGrades->post_id) {
                    $countId = Rating::countRowsForPostId($post->id);
                    $result = round($resultSummGrades->grades / $countId->post_id);
                    if ($result <= 2) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    private function getCountPositivePosts() : int
    {
        $count = 0;

        $arrayResultSummGrades = Rating::getSummaryGradeForIdentityPostId();

        foreach ($arrayResultSummGrades as $resultSummGrades) {
            foreach ($this->posts as $post) {
                if ($post->id === $resultSummGrades->post_id) {
                    $countId = Rating::countRowsForPostId($post->id);
                    $result = round($resultSummGrades->grades / $countId->post_id);
                    if ($result >= 4) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    public function getArrayAllCountsPosts() : array
    {
        $arrayAllCountsPosts = [];
        $arrayAllCountsPosts['all'] = $this->getCountAllPosts();
        $arrayAllCountsPosts['negative'] = $this->getCountNegativePosts();
        $arrayAllCountsPosts['positive'] = $this->getCountPositivePosts();
        return $arrayAllCountsPosts;
    }

}