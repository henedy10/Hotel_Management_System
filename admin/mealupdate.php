<?php 
require "../csrf.php";
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id_edit=$_POST['id_update'];
    $MealNameEdit=htmlspecialchars(strip_tags($_POST['mealnameedit']));
    $MealPriceEdit=$_POST['mealpriceedit'];
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF IS INVALID!");
    }

    if(empty($MealNameEdit)){
        $_SESSION['errors_edit']['mealname']="Meal name is required!";
    }
    if(empty($MealPriceEdit)){
        $_SESSION['errors_edit']['mealprice']="You must select value for meal price";
    }else if(!preg_match('/^[0-9]+$/',$MealPriceEdit)){
        $_SESSION['errors_edit']['mealprice']="Numbers is allowed only for meal price!";
    }

    if(empty($_SESSION['errors_edit'])){
        try{
            $sql_update_meal="UPDATE meals SET `name`=? , price=? WHERE id=?";
            $stmt=$conn->prepare($sql_update_meal);
            $stmt->bind_param("ssi",$MealNameEdit,$MealPriceEdit,$id_edit);
            $stmt->execute();
            $_SESSION['success_edit_msg']="Meal is updated successfully!";
            header("Location: ./meal.php");
            exit();
        }catch(mysqli_sql_exception $e){
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $_SESSION['failure_edit_msg']="This meal is exist already!";
            } else {
                $_SESSION['failure_edit_msg']="There is an error ".$stmt->error;
            }
                header("Location: ./mealedit.php");
                exit();
        }
    }else{
        header("Location: ./mealedit.php");
        exit();
    }
    $conn->close();
}
?>