<?php 
session_start();
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id_edit=$_POST['id_update'];
    $MealNameEdit=htmlspecialchars(strip_tags($_POST['mealnameedit']));
    $MealPriceEdit=$_POST['mealpriceedit'];

    if(empty($MealNameEdit)){
        $_SESSION['errors_edit']['mealname']="Meal name is required!";
    }
    if(empty($MealPriceEdit)){
        $_SESSION['errors_edit']['mealprice']="You must select value for meal price";
    }else if(!preg_match('/^[0-9]+$/',$MealPriceEdit)){
        $_SESSION['errors_edit']['mealprice']="Numbers is allowed only for meal price!";
    }

    if(empty($_SESSION['errors_edit'])){
        $sql_check_meal_exist="SELECT `name` FROM meals WHERE `name`=?";
        $stmt=$conn->prepare($sql_check_meal_exist);
        $stmt->bind_param("s",$MealNameEdit); 
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['errors_edit']['mealname']="This meal is exist already!";
            header("Location: ./mealedit.php");
            exit();
        }else{
            $sql_update_meal="UPDATE meals SET `name`=? , price=? WHERE id=?";
            $stmt=$conn->prepare($sql_update_meal);
            $stmt->bind_param("ssi",$MealNameEdit,$MealPriceEdit,$id_edit);
            if($stmt->execute()){
                $_SESSION['success_edit_msg']="Meal is updated successfully!";
                header("Location: ./meal.php");
                exit();
            }else{
                $_SESSION['failure_edit_msg']="There is an error . $stmt->error";
                header("Location: ./mealedit.php");
            }
        }
    }else{
        header("Location: ./mealedit.php");
        exit();
    }
    $conn->close();
}
?>