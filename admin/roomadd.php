<?php 
session_start();
require "../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    echo $_POST['typeroom'];
    $typeroom=$_POST['typeroom'];
    $typebed=$_POST['bed'];
    if(empty($typeroom)){
        $_SESSION['errors']['typeroom']="You must select value for room";
    }
    if(empty($typebed)){
        $_SESSION['errors']['bed']="You must select value for bed";
    }

    if(empty($_SESSION['errors'])){
        $sql_add_room="INSERT INTO rooms (room_type,bed_type) VALUES (?,?)";
        $stmt=$conn->prepare($sql_add_room);
        $stmt->bind_param("ss",$typeroom,$typebed);
        if($stmt->execute()){
            $_SESSION['success_msg']="The room has been added successfully.";
        }
    }
    header("Location: ./room.php");
    exit;
}
?>