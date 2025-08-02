<?php 
session_start();
require "../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $typeroom=$_POST['room_type'];
    $typebed=$_POST['bed_type'];
    $rentroom=$_POST['room_rent'];
    $rentbed=$_POST['bed_rent'];
    if(empty($typeroom)){
        $_SESSION['errors']['typeroom']="You must select value for room";
    }
    if(empty($typebed)){
        $_SESSION['errors']['typebed']="You must select value for bed";
    }
    if(empty($rentroom)){
        $_SESSION['errors']['rentroom']="You must input value for rent room";
    }
    if(empty($typebed)){
        $_SESSION['errors']['rentbed']="You must input value for rent bed";
    }

    if(empty($_SESSION['errors'])){
        $sql_add_room="INSERT INTO rooms (room_type,bed_type,room_rent,bed_rent) VALUES (?,?,?,?)";
        $stmt=$conn->prepare($sql_add_room);
        $stmt->bind_param("ssii",$typeroom,$typebed,$rentroom,$rentbed);
        if($stmt->execute()){
            $_SESSION['success_msg']="The room has been added successfully.";
        }
    }
    header("Location: ./room.php");
    exit;
}
?>