<?php
session_start();
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id_update=$_POST['edit_id'];
    $NameStaffEdit=htmlspecialchars(strip_tags($_POST['staffnameedit']));
    $RoleStaffEdit=$_POST['staffroleedit'];
    
    if(empty($NameStaffEdit)){
        $_SESSION['errors_edit']['staff_name_edit']="Staff Name is required";
    }
    if(empty($RoleStaffEdit)){
        $_SESSION['errors_edit']['staff_role_edit']="Staff Role is required";
    }

    if(empty($_SESSION['errors_edit'])){
        try{
            $sql_update_staff="UPDATE staff SET `name`=? , `role`=? WHERE id=?";
            $stmt=$conn->prepare($sql_update_staff);
            $stmt->bind_param("ssi",$NameStaffEdit,$RoleStaffEdit,$id_update);
            $stmt->execute();
            $_SESSION['success_edit_msg']="The staff has been updated successfully.";
            header("Location: ./staff.php");
            exit();
        }catch(mysqli_sql_exception $e){
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $_SESSION['failure_edit_msg']="This staff is exist already!";
            } else {
                $_SESSION['failure_edit_msg']="There is an error ".$stmt->error;
            }
                header("Location: ./staffedit.php");
                exit();
        }
    }else{
        header("Location: ./staffedit.php");
        exit();
    }
$conn->close();
}

?>