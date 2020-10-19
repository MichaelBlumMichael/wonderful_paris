<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(auth_user()){
    
    header('location: index.php');
    die;
}


$page_title = 'Sign-up';

$error['name'] = $error['email'] = $error['password'] = $error['image'] = '';

if(isset($_POST['submit'])){
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

    if(isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && 
    $_SESSION['csrf_token'] == $_POST['csrf_token']){
        
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $name = trim($name);
        $name = mysqli_real_escape_string($link, $name);

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = trim($email);
        $email = mysqli_real_escape_string($link, $email);


        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $password = trim($password);
        $password = mysqli_real_escape_string($link, $password);

        $is_form_valid = true;
        $image_name = 'profile.jpg';

        if( !$name || mb_strlen($name) < 2 || mb_strlen($name) > 50){
            $is_form_valid = false;
            $error['name'] = '* Name needs to be between 3-50 charecters.';
        }
        if(!$email){
            $is_form_valid = false;
            $error['email'] = '* A valid email is required.';

        }elseif(is_email_exists($email, $link)){
            $is_form_valid = false;
            $error['email'] = 'Email is already taken.';
        }
        if(! $password || strlen($password) < 6 || strlen($password) > 20){
            
            $is_form_valid = false;
            $error['password'] = '* Password should be between 6-20 charecters.';
        }

        if($is_form_valid && isset($_FILES['p_image']['tmp_name']) && $_FILES['p_image']['error'] == 0 ){
            
            if( check_avatar($_FILES)){
                $image_name = date('Y.m.d.H.i.s') . '-'. $_FILES['p_image']['name'];
                move_uploaded_file($_FILES['p_image']['tmp_name'], 'images/' . $image_name);

            }else{
                $is_form_valid = false;
                $error['image'] = 'The file must be an image. Size should be up to 5mb.';
            }
        }

        if($is_form_valid){
            
            $password = password_hash($password, PASSWORD_BCRYPT);
            $insert_user_query = "INSERT INTO users VALUES(null, '$name', '$email', '$password')";
            $insert_result = mysqli_query($link, $insert_user_query);

            if($insert_result && mysqli_affected_rows($link) > 0){
                $uid = mysqli_insert_id($link);
                $insert_user_profile_query = "INSERT INTO user_profiles VALUES(null, '$uid', '$image_name')";
                $insert_profile_result = mysqli_query($link, $insert_user_profile_query);
                if($insert_profile_result && mysqli_affected_rows($link) > 0){

                    $_SESSION['user_id'] = $uid;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                    header('location: blog.php');
                    exit;
                }
            }
        }
    }
        $token = csrf_token();
    } else{
        $token = csrf_token();
}


?>
<?php
include 'tpl/header.php';
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create an account!</h1>
                <p>Already have an account? <a href='login.php'>Log-in now!</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <form id='signin-form' method="POST" autocomplete="off" novalidate='novalidate' enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value=<?= $token; ?>>
                    <div class="form-group">
                        <label for="name-field">* Name</label>
                        <input value="<?= old('name'); ?>" type="text" name="name" id="name-field" class="form-control">
                        <span class="text-danger"><?=$error['name'];?></span>
                    </div>
                    <div class="form-group">
                        <label for="email-field">* Email</label>
                        <input value="<?= old('email'); ?>" type="email" name="email" id="email-field" class="form-control">
                        <span class="text-danger"><?= $error['email']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="pass-field">* Password</label>
                        <input type="password" name="password" id="pass-field" class="form-control">
                        <span class="text-danger"><?= $error['password'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="pass-field" id="inputGroupFile02">Profile Image:</label>
                    </div>
                    <div class="col-lg-5 custom-file">
                        <input type="file" name="p_image" class="custom-file-input" id="field-name">
                        <label class="custom-file-label" for="field-name">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text mt-1" id="">Upload</span>
                    </div>
                    <div class="form-group"><span class="text-danger"><?= $error['image'] ?></span></div>
                    <input type="submit" name="submit" value="Sign-Up!" class="btn btn-dark mt-4">
                </form>
            </div>
        </div>
    </div>
</main>
<?php include 'tpl/footer.php';?>
