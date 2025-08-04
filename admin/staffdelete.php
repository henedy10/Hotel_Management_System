<?php
session_start();
require "../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id=$_POST['id'];
    $sql_delete_staff="DELETE FROM staff WHERE id=?";
    $stmt=$conn->prepare($sql_delete_staff);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        $_SESSION['success_msg']="Staff is deleted successfully!";
    }else{
        $_SESSION['errors']['failure_msg']="There is an error".$stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: ./staff.php");
}



?>