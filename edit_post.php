<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(!auth_user()){

    header('location: signin.php');

}
$uid = $_SESSION['user_id'];

if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $post_id = mysqli_real_escape_string($link, $post_id);
    $post_query = "SELECT * FROM posts WHERE id= $post_id AND user_id = $uid";
    $post_result = mysqli_query($link,$post_query);
    if ( $post_result && mysqli_num_rows($post_result) > 0 ){
        $post = mysqli_fetch_assoc($post_result);
    } else {
        header('location: logout.php');
        exit;
    }
} else {
    header('location: logout.php');
    exit; 
}

$page_title = 'Edit your post';

$error['post_title'] = $error['post_body'] = '';


if(isset($_POST['submit'])){
    $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $post_title = trim($post_title);
    $post_body = filter_input(INPUT_POST, 'post_body', FILTER_SANITIZE_STRING);
    $post_body = trim($post_body);
    $is_form_valid = true;
    
    if(!$post_title || mb_strlen($post_title) < 3){
        $error['post_title'] = '* Please write at least 3 charecters';
        $is_form_valid = false;
    }
    if(!$post_body || mb_strlen($post_body) < 3){
        $error['post_body'] = '* Please write at least 3 charecters';
        $is_form_valid = false;
    }
    if($is_form_valid){
    
            $uid = $_SESSION['user_id'];
            $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
            $post_title = mysqli_real_escape_string($link, $post_title);
            $post_body = mysqli_real_escape_string($link, $post_body);
            $update_post_query = "UPDATE posts SET post_title = '$post_title', post_body = '$post_body' WHERE id = $post_id AND user_id = $uid";
            $update_result = mysqli_query($link, $update_post_query);

            if($update_result){
                header('location: blog.php');
                exit;
            }
    }
}

?>
<?php include 'tpl/header.php';?>
<main class="min-h-900">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <h1>Edit post</h1>
            </div>
        </div>
    
        <div class="col-12 mt-4">
            <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="form-group">
                    <label for="post_title">* Title</label>
                     <input type="text" name="post_title" class="form-control" id="post_title" value="<?= $post['post_title']; ?>">
                     <span class="text-danger"><?= $error['post_title'] ?></span>
                </div>
                <div class="form-group">
                    <label for="post_body">* Article</label>
                    <textarea class="form-control" name="post_body" id="post_body" cols="30" rows="10"><?= $post['post_body']; ?></textarea>
                    <span class="text-danger"><?= $error['post_body'] ?></span>
                </div>
                <input type="submit" value="Save Your Edit" name="submit" id="submit" class="btn btn-dark">
                <a href="blog.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
