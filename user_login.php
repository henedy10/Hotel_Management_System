<?php 
session_start();
require "config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $user_name=htmlspecialchars(strip_tags($_POST['Username']));
    $user_email=htmlspecialchars(strip_tags($_POST['Email']));
    $user_password=htmlspecialchars(stripslashes($_POST['Password']));

    if(empty($user_name)){
        $_SESSION['errors']['user_name_error']="Username is required!";
    }
    if(empty($user_email)){
        $_SESSION['errors']['user_email_error']="Email is required";
    }else if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors']['user_email_error']="Email is invalid";
    }
    
    if(empty($user_password)){
        $_SESSION['errors']['user_password_error']="Password is required";
    }else if(strlen($user_password)<8){
        $_SESSION['errors']['user_password_error']="Password must be 8 characters at least";
    }
    if(!empty($_SESSION['errors'])){
        header("Location: index.php");
        exit;
    }else{
        $sql_fetch_user="SELECT * FROM users WHERE name = ? AND email = ? ";
        $stmt=$conn->prepare($sql_fetch_user);
        $stmt->bind_param("ss",$user_name,$user_email);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            if(!password_verify($user_password,$row['password'])){
                $_SESSION['errors']['user_password_error']="Password is incorrect!";
                header("Location: index.php");
                exit;
            }else{
                $_SESSION['user_name']=$row['name'];
                $_SESSION['user_email']=$row['email'];
                header("Location: home.php?id=$row[id]");
                exit;
            }
        }else{
            $_SESSION['exist_account_msg']="This account is not exist! ";
            header("Location: index.php");
            exit;
        }
    }
}
?>