<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/app.css">
</head>
<body>

<!--  Header Section  -->
    <header class="header mt-5 mb-5">
        <div class="container">
            <h2 class="title text-center mb-3">COUNTER</h2>
            <div class="row justify-content-between">
                <div class="card text-bg-primary mb-3" style="max-width: 12rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $allCountsPosts['negative'] ?></h5>
                        <div class="list-group-item list-group-item-action text-center"><i class="fa-solid fa-thumbs-down"></i> Negative Posts</div>
                    </div>
                </div>
                <div class="card text-bg-primary mb-3" style="max-width: 12rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $allCountsPosts['all'] ?></h5>
                        <div class="list-group-item list-group-item-action text-center"><i class="fa-solid fa-lines-leaning"></i> All Posts</div>
                    </div>
                </div>
                <div class="card text-bg-primary mb-3" style="max-width: 12rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $allCountsPosts['positive'] ?></h5>
                        <div class="list-group-item list-group-item-action text-center"><i class="fa-solid fa-thumbs-up"></i> Positive Posts</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<!--  /Header Section  -->

<!--  Main Section  -->
    <main class="main">
        <div class="container">
            <div class="row">
                <h2 class="title text-center mb-3">POSTS</h2>
                <button type="button" class="btn btn-primary mb-3" style="width: 8rem; margin-left: auto;" data-bs-toggle="modal" data-bs-target="#addPostModal"><i class="fa-solid fa-square-plus"></i> Add Post</button>
<!-- Posts-->
                <?php foreach ($posts as $post): ?>

                <section class="posts mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                    <div class="card-title w-25"><strong>by <?= $post->getUserById($post->user_id)->name; ?></strong></div>
                                <button data-comment="<?= $post->id ?>" class="buttonAddComment btn btn-success mb-3" style="display: inline-block; width: 12rem; margin-left: auto;" data-bs-toggle="modal" data-bs-target="#addCommentModal"><i class="fa-solid fa-square-plus"></i> Add Comment</button>
                            </div>
                            <p class="card-text"><?= $post->content ?></p>
                            <div class="row justify-content-between">
                                <div class="card-text w-25">

                                    <?php if($post->getRatingFromUser()): ?>
                                    <div class="rating-result">
                                        <?php for($i = 1; $i <= $post->getRatingFromUser(); $i++): ?>
                                        <span class="active"></span>
                                        <?php endfor; ?>
                                        <?php for($i = 1; $i <= (5 - $post->getRatingFromUser()); $i++): ?>
                                        <span></span>
                                        <?php endfor; ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!$post->getRatingFromUser()): ?>
                                        <form action="/index.php" method="post" id="<?= $post->id ?>">
                                            <div class="rating-area">
                                                <input type="radio" class="star-5" name="rating" value="5">
                                                <label for="star-5" class="stars" title="Оценка «5»"></label>
                                                <input type="radio" class="star-4" name="rating" value="4">
                                                <label for="star-4" class="stars" title="Оценка «4»"></label>
                                                <input type="radio" class="star-3" name="rating" value="3">
                                                <label for="star-3" class="stars" title="Оценка «3»"></label>
                                                <input type="radio" class="star-2" name="rating" value="2">
                                                <label for="star-2" class="stars" title="Оценка «2»"></label>
                                                <input type="radio" class="star-1" name="rating" value="1">
                                                <label for="star-1" class="stars" title="Оценка «1»"></label>
                                                <input type="hidden" class="form-control" id="grade_<?= $post->id ?>" name="grade" value="">
                                                <input type="hidden" class="form-control" id="post-rating_<?= $post->id ?>" name="post_id" value="<?= $post->id ?>">
                                                <input type="hidden" class="form-control" id="user-rating_<?= $post->id ?>" name="name" value="<?= ($_SESSION['name']) ?? '' ?>">
                                                <div style="visibility: hidden;">
                                                    <button type="submit" id="submit-btn-<?= $post->id ?>"></button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                </div>
                                <div class="card-text ml-a" style="width: 8rem;"><?= $post->created_at ?></div>
                            </div>

                        </div>
                    </div>
                </section>
<!-- /Posts-->
<!-- Comments Section -->
                <?php foreach ($comments as $comment): ?>
                    <?php if ($post->id === $comment->post_id): ?>
                    <section class="comments mb-3 w-75" style="margin-left: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                            <div class="card-title w-25"><strong>by <?= $comment->getUserById($comment->user_id)->name ?></strong></div>

                                </div>
                                <p class="card-text"><?= $comment->message ?></p>
                                <div class="card-text" style="width: 8rem; margin-left: auto;"><?= $comment->created_at ?></div>

                            </div>
                        </div>
                    </section>
                    <?php endif; ?>
                <?php endforeach; ?>
<!-- Comments Section -->
                <?php endforeach; ?>
                <!-- Posts-->
            </div>
        </div>
    </main>
<!--  /Main Section  -->

<!-- Modal Post -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/index.php" method="post">
                    <div class="mb-3">
                        <label for="nameFromPost" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameFromPost" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Text<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="add_post">Add Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Post -->

<!-- Modal Comment -->
<div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/index.php" method="post">
                    <div class="mb-3">
                        <label for="nameFromComment" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameFromComment" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Comment<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" required></textarea>
                    </div>
                    <input type="hidden" class="form-control" id="post_id" name="post_id">
                    <button type="submit" class="btn btn-success" id="add_message">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Comment-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="./assets/app.js"></script>
</body>
</html>