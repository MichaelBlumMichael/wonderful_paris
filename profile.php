<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(!auth_user()){

    header('location: index.php');
    exit;
}

$page_title = htmlentities($_SESSION['user_name']);

$uid = $_SESSION['user_id'];
$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$user_query = "SELECT up.image_name, u.name, u.email
        FROM users AS u
        JOIN user_profiles AS up ON u.id = up.user_id
        WHERE u.id = '$uid';";
$user_data_result = mysqli_query($link, $user_query);

if(isset($_POST['submit']) && isset($_FILES['p_image']['tmp_name']) && $_FILES['p_image']['error'] == 0 ){

    $error_img = '';

    if(check_avatar($_FILES)){
        $image_name = date('Y.m.d.H.i.s') . '-'. $_FILES['p_image']['name'];
        move_uploaded_file($_FILES['p_image']['tmp_name'], 'images/' . $image_name);
        
        $sql_update_pic = "UPDATE user_profiles
                JOIN users ON users.id = user_profiles.user_id 
                SET user_profiles.image_name = '$image_name' 
                WHERE users.id = '$uid';";
        $profile_pic_result = mysqli_query($link, $sql_update_pic);

        if($profile_pic_result && mysqli_affected_rows($link) > 0){
           header('location: profile.php');
           exit;
        }
    }else{
        $error_img['p_image'] = 'The file must be an image. Size should be up to 5mb.';
    }

}

$error_pass = '';

if(isset($_POST['submit_password'])){
    
    $is_pass_valid = true;

    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $password = filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING);
    $password = trim($password);
    $password = mysqli_real_escape_string($link, $password);

    if(!$password || strlen($password) < 6 || strlen($password) > 20){
        
        $is_pass_valid = false;
        $error_pass = '* Password should be between 6-20 charecters.';
    }

    if($is_pass_valid){

        $password = password_hash($password, PASSWORD_BCRYPT);
        $update_pass_query = "UPDATE users
                SET users.password = '$password'
                WHERE id = '$uid';
        ";
        $update_pass_result = mysqli_query($link, $update_pass_query);

        if($update_pass_result && mysqli_affected_rows($link) > 0){
            header('location: index.php');
        }

    }
}


?>
<?php include 'tpl/header.php';?>

<main class="min-h-900">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4 text-index text-center mt-3 p-2">
                <h1>Your Profile</h1>
                <h4>Here you can see all the details about your profile.</h4>
                
                <?php if( $user_data_result && mysqli_num_rows($user_data_result) > 0 ):?>
                <?php while($profile = mysqli_fetch_assoc($user_data_result)): ?>
                    <p>User name: <?= htmlentities($_SESSION['user_name']) ?></p>
                    <p>Your Email: <?= $profile['email'] ?></p>
                    <span><img width="100" class="mr-2 rounded-circle" src="images/<?=$profile['image_name']?>" alt=""></span>
                <?php endwhile;?>
                <?php endif;?>
                
                <form id='change-photo' method="POST" autocomplete="off" novalidate='novalidate' enctype="multipart/form-data">
                    <div>
                        <h3><label>Change Profile picture:</label></h3>
                    </div> 
                    <div class="col-lg-5 custom-file">
                        <input type="file" name="p_image" class="custom-file-input" id="field-name">
                        <label class="custom-file-label" for="field-name">Choose file</label>
                    </div>
                    <div class="col-lg-5 custom-file">
                        <input type="submit" name="submit" value="Upload" class="btn btn-dark">  
                    </div>
                    <br><br>
                </form>
                <form method="POST" autocomplete="off" novalidate='novalidate' enctype="multipart/form-data">
                    <div>
                    <h3><label for="prof_password">Update Your pasword:</label></h3>
                    </div>
                    <div class="col-lg-5 custom-file">
                        <input type="password" name="new_pass"  class="form-control text-center" id="prof_password" placeholder="Password">
                    </div>
                    <div class="col-lg-5 custom-file">
                        <input type="submit" name="submit_password" value="Update password" class="btn btn-dark">  
                    </div>
                    <br><br>
                    <span class="text-danger"><?= $error_pass ?></span>
                </form>
                <br><br>
            </div>
        </div>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>

