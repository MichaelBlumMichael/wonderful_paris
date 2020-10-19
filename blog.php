<?php
session_start();
session_regenerate_id();
$page_title = 'Blog Page';
require_once 'app/helpers.php';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$post_query = "SELECT up.image_name, u.name, p.*, DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') pdate 
        FROM posts AS p 
        JOIN users AS u ON u.id = p.user_id 
        JOIN user_profiles AS up ON u.id = up.user_id 
        ORDER BY p.date DESC;";

$post_query_result = mysqli_query($link, $post_query);

if(auth_user()) {
    $uid = $_SESSION['user_id'];
} else {
    $uid = '';
}

?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
            <h1>The Blog</h1>
            <?php if(auth_user()): ?>
            <a href="add_post.php" class="btn btn-dark mt-4">Add new post</a>
            <?php else :?>
                <a href="signup.php" class="btn btn-dark mt-4">Please create an account!</a> 
                <a href="login.php" class="btn btn-dark mt-4">Log-In</a>
            <?php endif; ?>
            </div>
        </div>
        <?php if( $post_query_result && mysqli_num_rows($post_query_result) > 0 ):?>
        <div class="row">
            <?php while($post = mysqli_fetch_assoc($post_query_result)): ?>
                
                <?php                 
                $comments_query = "SELECT users.name AS name, comments.* FROM comments 
                JOIN posts ON posts.id = comments.post_id 
                JOIN users ON comments.comment_writer_id = users.id
                WHERE posts.id = $post[id];";
                $comments_results = mysqli_query($link, $comments_query);?>
                
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-title border-bottom p-3">
                            <span><img width="30px" class="mr-2 rounded-circle" src="images/<?=$post['image_name']?>" alt="">
                            <b><?= htmlentities($post['name']); ?></b></span>
                            <span class="float-right"><?=  $post['pdate']; ?></span>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><?= htmlentities($post['post_title']); ?></h2>
                            <p class="card-text"><?= str_replace("\n", '<br>', htmlentities($post['post_body'])); ?></p>
                        <div class="comments">
                        <?php while($comment = mysqli_fetch_assoc($comments_results)):?>
                                <p class="comment-text-name"><?= str_replace("\n", '<br>', htmlentities($comment['name'])); ?></p>
                                <p class="comment-text-date"><?= str_replace("\n", '<br>', htmlentities($comment['date'])); ?></p>
                                <p class="comment-text-comment"><?= str_replace("\n", '<br>', htmlentities($comment['comment'])); ?><br></p>
                            <?php endwhile; ?>
                        </div>
                            

                            <?php if($uid == $post['user_id']): ?>
                            <div class="dropdown float-right">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="edit_post.php?post_id= <?= $post['id']?>">Edit</a>
                                    <a class="dropdown-item delete-btn" 
                                    href="delete.php?post_id= <?= $post['id']?>">Delete</a>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(auth_user()):?>
                            <div class="float-left">
                            <a href="comment.php?post_id= <?= $post['id']?>" class="btn btn-secondary">Comment</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>