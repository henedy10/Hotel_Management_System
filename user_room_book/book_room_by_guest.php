<?php
session_start();
require "../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $guest_name=htmlspecialchars(strip_tags($_POST['Name']));
    $guest_email=htmlspecialchars(strip_tags($_POST['Email']));
    $guest_phone=htmlspecialchars(strip_tags($_POST['Phone']));
    $guest_room_selected=$_POST['RoomType'];
    $guest_bed_selected=$_POST['Bed'];
    $guest_meal_selected=$_POST['Meal'];
    $check_in=$_POST['cin'];
    $check_out=$_POST['cout'];

    // validation guest information

    if(empty($guest_name)){
        $_SESSION['errors_guest_info']['name']="User name is required!";
    }
    if(empty($guest_email)){
        $_SESSION['errors_guest_info']['email']="Email is required!";
    }else if(!filter_var($guest_email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors_guest_info']['email']="Email is invalid!";
    }
    if(empty($guest_phone)){
        $_SESSION['errors_guest_info']['phone']="Your phone is required!";
    }
    if(empty($_SESSION['errors_guest_info'])){
        $sql_check_account_exist="SELECT * FROM users WHERE `name`=? AND email=?";
        $stmt=$conn->prepare($sql_check_account_exist);
        $stmt->bind_param("ss",$guest_name,$guest_email);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows<=0){
            $_SESSION['account_exist_msg']="This account is not exist, Must create an account ";
        }
    }

    // validation reservation information

    if(empty($guest_room_selected)){
        $_SESSION['errors_reservation_info']['room']="You must select type for your room";
    }
    if(empty($guest_bed_selected)){
        $_SESSION['errors_reservation_info']['bed']="You must select type for your bed";       
    }
    if(empty($guest_meal_selected)){
        $_SESSION['errors_reservation_info']['meal']="You must select type for your meal";
    }
    if(empty($check_in)){
        $_SESSION['errors_reservation_info']['check_in']="check_in input is required!";
    }
    if(empty($check_out)){
        $_SESSION['errors_reservation_info']['check_out']="check_out input is required!";
    }else if($check_out<$check_in){
        $_SESSION['errors_reservation_info']['check_out']="check_out must be equal or less than check_in!";
    }

    if(empty($_SESSION['errors_reservation_info'])&&empty($_SESSION['errors_guest_info'])&&empty($_SESSION['account_exist_msg'])){
        $sql_save_order="INSERT INTO room_booking(guest_name,guest_email,guest_phone,room_type,bed_type,meal,check_in,check_out) VALUES (?,?,?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql_save_order);
        $stmt->bind_param("ssssssss",
            $guest_name,
            $guest_email,
            $guest_phone,
            $guest_room_selected,
            $guest_bed_selected,
            $guest_meal_selected,
            $check_in,
            $check_out
        );
        if($stmt->execute()){
            $_SESSION['success_msg']="Your order is submission successfully";
        }else{
            echo "error : ".$stmt->error;
        }
        $stmt->close();
    }
    $conn->close();

    header("Location: ./roombookconfirm.php");
    exit;
}
?>