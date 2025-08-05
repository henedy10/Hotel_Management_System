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
        $sql_check_staff_name_exist="SELECT * FROM staff WHERE `name`=?";
        $stmt=$conn->prepare($sql_check_staff_name_exist);
        $stmt->bind_param("s",$NameStaffEdit);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['errors_edit']['staff_name']="This Name is exist already!";
            header("Location: ./staffedit.php");
        }else{
            $sql_update_staff="UPDATE staff SET `name`=? , `role`=? WHERE id=?";
            $stmt=$conn->prepare($sql_update_staff);
            $stmt->bind_param("ssi",$NameStaffEdit,$RoleStaffEdit,$id_update);
            if($stmt->execute()){
                $_SESSION['success_edit_msg']="The staff has been updated successfully.";
                header("Location: ./staff.php");
                exit;
            }
        }
    }else{
        header("Location: ./staffedit.php");
        exit();
    }
$conn->close();
}

?>