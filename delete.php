<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(!auth_user()){

    header('location: signin.php');

}
$uid = $_SESSION['user_id'];

if(isset($_GET['post_id']) && is_numeric($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $post_id = mysqli_real_escape_string($link, $post_id);
    $sql = "DELETE FROM posts WHERE id = $post_id AND user_id = $uid";
    mysqli_query($link, $sql);
    header('location: blog.php');
}