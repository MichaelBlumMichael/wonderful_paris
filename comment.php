<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(!auth_user()){
    header('location: signin.php');
}

require_once 'app/helpers.php';
$page_title = 'Add Comment';

$error['post_body'] = '';

if(isset($_POST['submit']) && isset($_GET['post_id'])){
    $post_body = filter_input(INPUT_POST, 'post_body', FILTER_SANITIZE_STRING);
    $post_body = trim($post_body);
    $is_form_valid = true;
    
    if(!$post_body || mb_strlen($post_body) < 3){
        $error['post_body'] = '* Please write at least 3 charecters';
        $is_form_valid = false;
    }

    if($is_form_valid){
            $uid = $_SESSION['user_id'];
            $post_id = $_GET['post_id'];
           
            $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
            $post_body = mysqli_real_escape_string($link, $post_body);

            $sql = "INSERT INTO comments (comment_id, post_id, comment_writer_id, comment, date)
            SELECT null, '$post_id', '$uid', '$post_body', NOW()
            FROM posts JOIN users on posts.user_id = users.id
            WHERE posts.id = '$post_id'";

            $insert_result = mysqli_query($link, $sql);
            
            if($insert_result && mysqli_affected_rows($link) > 0){
                
                header('location: blog.php');
            }
    }
}

?>
<?php include 'tpl/header.php';?>
<main class="min-h-900">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4 text-index">
                <h1>Add your Comment</h1>
            </div>
        </div>
    
        <div class="col-12 mt-4">
            <form method="POST" novalidate="novalidate" autocomplete="off">
                <div class="form-group">
                    <textarea class="form-control" name="post_body" id="post_body" cols="30" rows="10"><?= old('post_body'); ?></textarea>
                    <span class="text-danger"><?= $error['post_body'] ?></span>
                </div>
                <input type="submit" value="Add" name="submit" id="submit" class="btn btn-primary">
                <a href="blog.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
