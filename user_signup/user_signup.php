<?php

require "../csrf.php";
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $user_name_signup=htmlspecialchars(strip_tags($_POST['Username_Signup']));
    $user_email_signup=htmlspecialchars(strip_tags($_POST['Email_Signup']));
    $user_password_signup=htmlspecialchars(strip_tags($_POST['Password_Signup']));
    $user_confirm_password_signup=htmlspecialchars(strip_tags($_POST['CPassword_Signup']));
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF IS INVALID!");
    }
    if(empty($user_name_signup)){
        $_SESSION['errors']['user_name_signup']="Username is required!";
    }else if(!preg_match("/^[a-zA-Z0-9\s]+$/",$user_name_signup)){
        $_SESSION['errors']['user_name_signup']="Only letters,0-9 and white space allowed";
    }

    if(empty($user_email_signup)){
        $_SESSION['errors']['user_email_signup']="Email is required!";
    }else if(!filter_var($user_email_signup,FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors']['user_email_signup']="Email is invalid!";
    }

    if(empty($user_password_signup)){
        $_SESSION['errors']['user_password_signup']="Password is required!";
    }else if(strlen($user_password_signup)<8){
        $_SESSION['errors']['user_password_signup']="Password must be 8 characters at least!";
    }

    if(empty($user_confirm_password_signup)){
        $_SESSION['errors']['user_confirm_password_signup']="Confirm Password input is required!";
    }else if($user_confirm_password_signup !== $user_password_signup){
        $_SESSION['errors']['user_confirm_password_signup']="Password doesn't match";
    }

    if(!empty($_SESSION['errors'])){
        header("Location: user_signup_view.php");
        exit;
    }else{
        $sql_check_account_exist="SELECT * FROM users WHERE `name`=? OR email=?";
        $stmt=$conn->prepare($sql_check_account_exist);
        $stmt->bind_param("ss",$user_name_signup,$user_email_signup);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['exist_account_msg']="name or email is used already!";
            header("Location: user_signup_view.php");
            exit;
        }else{
            $hash_password=password_hash($user_password_signup,PASSWORD_DEFAULT);
            $sql_store_account="INSERT INTO users (`name`,email,`password`) VALUES (?,?,?)";
            $stmt=$conn->prepare($sql_store_account);
            $stmt->bind_param("sss",$user_name_signup,$user_email_signup,$hash_password);
            $stmt->execute();
            $resutl=$stmt->get_result();
            if(isset($result)){
                $_SESSION['success_msg']="Your Account is created successfully!";
                header("Location: user_signup_view.php");
                exit;
            }
        }
    }
}
?>