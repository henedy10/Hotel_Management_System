<?php 
session_start();
require "config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $user_name=htmlspecialchars(strip_tags($_POST['Username']));
    $user_email=htmlspecialchars(strip_tags($_POST['Email']));
    $user_password=htmlspecialchars(stripslashes($_POST['Password']));

    if(empty($user_name)){
        $_SESSION['user_name_error']="Username is required!";
    }
    if(empty($user_email)){
        $_SESSION['user_email_error']="Email is required";
    }else if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['user_email_error']="Email is invalid";
    }
    
    if(empty($user_password)){
        $_SESSION['user_password_error']="Password is required";
    }else if(strlen($user_password)<8){
        $_SESSION['user_password_error']="Password must be 8 characters at least";
    }
    if(isset($_SESSION['user_name_error'])||isset($_SESSION['user_email_error'])||isset($_SESSION['user_password_error'])){
        header("Location: index.php");
    }else{
        $sql_fetch_user="SELECT * FROM users WHERE name = ? AND email = ? AND `password` = ?";
        $stmt=$conn->prepare($sql_fetch_user);
        $stmt->bind_param("sss",$user_name,$user_email,$user_password);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            header("Location: home.php?id = $row[id]");
        }else{
            $_SESSION['exist_account_msg']="This account is not exist! ";
            header("Location: index.php");
        }
    }
}







?>