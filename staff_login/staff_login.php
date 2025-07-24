<?php 
session_start();
require "../config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $employee_email=htmlspecialchars(strip_tags($_POST['Emp_Email']));
    $employee_password=htmlspecialchars(strip_tags($_POST['Emp_Password']));

    if(empty($employee_email)){
        $_SESSION['errors']['employee_email_error']="Email is required!";
    }else if(!filter_var($employee_email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors']['employee_email_error']="Email is invalid!";
    }

    if(empty($employee_password)){
        $_SESSION['errors']['employee_password_error']="Password is required!";
    }

    if(empty($_SESSION['errors'])){
        $sql_check_account="SELECT * FROM staff WHERE email=?";
        $stmt=$conn->prepare($sql_check_account);
        $stmt->bind_param('s',$employee_email);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            if(!password_verify($employee_password,$row['password'])){
                $_SESSION['exist_account_msg']="Password is incorrect";
                header("Location: ../staff_login/staff_login_view.php");
                exit;
            }else{
                header("Location: ../admin/admin.php");
                exit;
            }
        }else{
            $_SESSION['exist_account_msg']="This account doesn't exist";
            header("Location: ../staff_login/staff_login_view.php");
            exit;
        }
    }else{
        header("Location: ../staff_login/staff_login_view.php");
        exit;
    }
}
?>