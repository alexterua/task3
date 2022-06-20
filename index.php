<?php

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Rating;
use App\Models\Counter;
use App\View;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/functions.php';

spl_autoload_register('my_autoloader');

session_start();

if (isset($_SESSION['name'])) {
    $_SESSION['name'] = User::createOrFind($_SESSION['name'])->name;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['grade']) && isset($_POST['post_id'])) {
        Rating::create($_POST);
    }

    if (isset($_POST['content']) && isset($_POST['name'])) {
        if (strlen(trim($_POST['name'])) != 0) {
            if (strlen(trim($_POST['content'])) != 0) {
                $_POST['content'] = htmlentities($_POST['content']);
                $_POST['name'] = htmlentities($_POST['name']);
                if (!isset($_SESSION['name'])) {
                    $_SESSION['name'] = User::createOrFind($_POST['name'])->name;
                }
                Post::createOrFind($_POST);
            }
        }
    }

    if (isset($_POST['message']) && isset($_POST['name'])) {
        if (strlen(trim($_POST['name'])) != 0) {
            if (strlen(trim($_POST['message'])) != 0) {
                $_POST['message'] = htmlentities($_POST['message']);
                $_POST['name'] = htmlentities($_POST['name']);
                if (!isset($_SESSION['name'])) {
                    $_SESSION['name'] = User::createOrFind($_POST['name'])->name;
                }
                Comment::createOrFind($_POST);
            }
        }
    }
}

$ratings = Rating::getAll();
$posts = Post::getAll();
$comments = Comment::getAll();
$users = User::getAll();

$counter = new Counter($posts, $ratings);
$allCountsPosts = $counter->getArrayAllCountsPosts();

$view = new View();
echo $view->assign('posts', $posts)
    ->assign('comments', $comments)
    ->assign('users', $users)
    ->assign('ratings', $ratings)
    ->assign('allCountsPosts', $allCountsPosts)
    ->render('index');

