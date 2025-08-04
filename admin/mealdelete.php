<?php
session_start();
require "../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id=$_POST['id'];
    $sql_delete_meal="DELETE FROM meals WHERE id=?";
    $stmt=$conn->prepare($sql_delete_meal);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        $_SESSION['success_msg_meal']="Meal is deleted successfully!";
    }else{
        $_SESSION['failure_msg_meal']="There is an error".$stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: ./meal.php");
}



?>