<?php
require_once 'db_config.php';

if( !function_exists('old')){

    /**
     * Restore the last value of a field.
     * 
     * @param string '$fn the field name'
     * @return string
     */
    function old($fn){
        return $_REQUEST[$fn] ?? '';
    }
}

    /**
     * Generate csrf token, protects against Cross Site Request Forgery.
     * 
     * @return string
     */
if(!function_exists('csrf_token')){

    function csrf_token() {
        $token = sha1(rand(1, 1000). date('Y.m.d.h.i.s'). 'paris$$');
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}

/**
 * Checks if the user that is connected is a verified user.
 *
 * @return bool
 */ 
if(!function_exists('auth_user')){
    function auth_user(){
        $auth = false;
        if(isset($_SESSION['user_id'])){
            if(isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']){
                if(isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']){

                    $auth = true;

                }
            }

        }
        return $auth;
    }
}

/**
 * Checks if an email already exists in the databse.
 *
 * @param string $email Checks the users email.
 * @param string $link Contains the database connection values.
 * 
 * @return bool
 */
if( !function_exists('is_email_exists')){
    function is_email_exists($email, $link){
        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $sql);

        if($result && mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}

/**
 * Validates that an uploaded image complies with the necessary validations.
 *
 * @global $file contains Global $_FILE variable .
 * @return bool
 * 
 */
if(!function_exists('check_avatar')){
    function check_avatar($file){
        $valid = false;
        $allowd = [
            'max_file_size' => 1024 * 1025 * 5,
            'ex' => ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
            'mime' => ['image/jpeg', 'image/bmp', 'image/gif', 'image/png']
        ];

        if(isset($file['p_image']['size']) && $file['p_image']['size'] <= $allowd['max_file_size']){
            
            if(isset($file['p_image']['type']) && in_array(strtolower($file['p_image']['type']), $allowd['mime'])){

                if(isset($file['p_image']['name'])){
                    
                    $file_detailed = pathinfo($file['p_image']['name']);//shows the extantion details.
                
                    if(in_array(strtolower($file_detailed['extension']), $allowd['ex'])){

                        if( is_uploaded_file($file['p_image']['tmp_name']) ){

                            $valid = true;

                        }
    
                    }

                }

               
            }

        }
        return $valid;
    }
}