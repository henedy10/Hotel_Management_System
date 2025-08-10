<?php
require __DIR__ ."/../../csrf.php";
require __DIR__ ."/../../database/config.php";


if($_SERVER['REQUEST_METHOD']=="POST"){
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF is invalid!");
    }
    $id=$_POST['id'];
    $sql_delete_room="DELETE FROM rooms WHERE id=?";
    $stmt=$conn->prepare($sql_delete_room);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        $_SESSION['success_msg']="Room is deleted successfully!";
    }else{
        $_SESSION['errors']['failure_msg']="There is an error".$stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: ./room.php");
}



?>