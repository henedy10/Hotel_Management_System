<?php 
session_start();
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['guestdetailedit'])){
    $guest_name=htmlspecialchars(strip_tags($_POST['EditName']));
    $guest_email=htmlspecialchars(strip_tags($_POST['EditEmail']));
    $guest_phone=htmlspecialchars(strip_tags($_POST['EditPhone']));
    $guest_room_selected=$_POST['EditRoomType'];
    $guest_bed_selected=$_POST['EditBed'];
    $guest_meal_selected=$_POST['EditMeal'];
    $check_in=$_POST['Editcin'];
    $check_out=$_POST['Editcout'];

    // validation guest information

    if(empty($guest_name)){
        $_SESSION['errors_edit_guest_info']['edit_name']="User name is required!";
    }
    if(empty($guest_email)){
        $_SESSION['errors_edit_guest_info']['edit_email']="Email is required!";
    }else if(!filter_var($guest_email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors_edit_guest_info']['edit_email']="Email is invalid!";
    }
    if(empty($guest_phone)){
        $_SESSION['errors_edit_guest_info']['edit_phone']="Your phone is required!";
    }
    if(empty($_SESSION['errors_edit_guest_info'])){
        $sql_check_account_exist="SELECT * FROM users WHERE `name`=? AND email=?";
        $stmt=$conn->prepare($sql_check_account_exist);
        $stmt->bind_param("ss",$guest_name,$guest_email);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows<=0){
            $_SESSION['edit_account_exist_msg']="This account is not exist, Must create an account ";
        }
    }

    // validation reservation information

    if(empty($guest_room_selected)){
        $_SESSION['errors_edit_reservation_info']['edit_room']="You must select type for your room";
    }
    if(empty($guest_bed_selected)){
        $_SESSION['errors_edit_reservation_info']['edit_bed']="You must select type for your bed";       
    }
    if(empty($guest_meal_selected)){
        $_SESSION['errors_edit_reservation_info']['edit_meal']="You must select type for your meal";
    }
    if(empty($check_in)){
        $_SESSION['errors_edit_reservation_info']['edit_check_in']="check_in input is required!";
    }
    if(empty($check_out)){
        $_SESSION['errors_edit_reservation_info']['edit_check_out']="check_out input is required!";
    }else if($check_out<$check_in){
        $_SESSION['errors_edit_reservation_info']['edit_check_out']="check_out must be equal or less than check_in!";
    }

    if(empty($_SESSION['errors_edit_reservation_info'])&&empty($_SESSION['errors_edit_guest_info'])&&empty($_SESSION['edit_account_exist_msg'])){
        $sql_check_exist_order="SELECT room_type,bed_type FROM rooms WHERE room_type=? AND bed_type=? ";
        $stmt=$conn->prepare($sql_check_exist_order);
        $stmt->bind_param("ss",$guest_room_selected,$guest_bed_selected);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $sql_edit_order="UPDATE room_booking SET 
                guest_name=?,
                guest_email=?,
                guest_phone=?,
                room_type=?,
                bed_type=?,
                meal=?,
                check_in=?,
                check_out=?
            ";
            $stmt=$conn->prepare($sql_edit_order);
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
                $_SESSION['success_edit_msg']="Your order is updated successfully";
            }else{
                echo "error : ".$stmt->error;
            }
        }else{
            $_SESSION['check_exist_order']="This order is not available now ";
        }
    }

    header("Location: ./roombookedit.php");
    exit;
}
?>