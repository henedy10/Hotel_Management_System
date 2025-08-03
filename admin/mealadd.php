<?php
session_start();
require "../database/config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $MealName = htmlspecialchars(strip_tags($_POST['mealname']));
    $MealPrice= $_POST['mealprice'];

    if(empty($MealName)){
        $_SESSION['errors_meal']['name']="Name of Meal is required";
    }
    
    if(is_null($MealPrice)){
        $_SESSION['errors_meal']['price']="Price of Meal is required";
    }else if ($MealPrice<0){
        $_SESSION['errors_meal']['price']="Price of Meal Must be greater than or equal Zero";        
    }

    if(empty($_SESSION['errors_meal'])){
        $sql_check_meal="SELECT * FROM meals WHERE `name`=?";
        $stmt=$conn->prepare($sql_check_meal);
        $stmt->bind_param("s",$MealName);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['failure_msg_meal']="This meal is exist already!";
        }else{
            $sql_save_meal="INSERT INTO meals (`name`,price) VALUES (?,?)";
            $stmt=$conn->prepare($sql_save_meal);
            $stmt->bind_param("si",$MealName,$MealPrice);
            if($stmt->execute()){
                $_SESSION['success_msg_meal']="The meal is added successfully";
            }else{
                $_SESSION['failure_msg_meal']="There is an error ". $stmt->error;
            }
        }
        $stmt->close();
    }
    $conn->close();
    header('Location: ./meal.php');
    exit;
}
?>