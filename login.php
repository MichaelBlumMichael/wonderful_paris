<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(auth_user()){
    
    header('location: index.php');
    die;
}

$page_title = 'Log-in';

$error = '';

if(isset($_POST['submit'])){

    if(isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && 
    $_SESSION['csrf_token'] == $_POST['csrf_token']){

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = trim($email);
        
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $password = trim($password);

    if (!$email){
        $error = '* A valid email is required';
    } elseif (!$password){
        $error = '* A valid password is required';
    } else {
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        $user_query = "SELECT * FROM users WHERE email = '$email'";
        $user_result = mysqli_query($link, $user_query);

        if($user_result && mysqli_num_rows($user_result) > 0){      
            $user = mysqli_fetch_assoc($user_result);
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                header('location: blog.php');
                exit;
            } else {
               $error = '* Wrong Email or password.';
            }

        } else {
            $error = '* Wrong Email.';
        }
    }
}
    $token = csrf_token();
} else {
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
                <h1>Please Log in</h1>
                <p>No account? <a href='signup.php' class="btn btn-dark">Sign up now!</a></p>
            </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                <form id='signin-form' method="POST" autocomplete="off" novalidate='novalidate'>
                    <input type="hidden" name="csrf_token" value=<?= $token; ?>>
                    <div class="form-group">
                        <label for="email-field">* Email</label>
                        <input value="<?= old('email'); ?>" type="email" name="email" id="email-field" class="form-control">
                    </div>        
                    <div class="form-group">
                        <label for="pass-field">* Password</label>
                        <input type="password" name="password" id="pass-field" class="form-control">
                    </div> 
                    <input type="submit" name="submit" value="Log-In" class="btn btn-dark">  
                    <span class="text-danger"><?= $error; ?></span>    
                </form>
            </div>
           </div> 
        </div>
    </main>
<?php include 'tpl/footer.php'; ?>
