<?php 
require __DIR__ ."/../../csrf.php";
require __DIR__ ."/../../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $name_staff=htmlspecialchars(strip_tags($_POST['staffname']));
    $role_staff=$_POST['staffrole'];
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF is invalid!");
    }
    if(empty($name_staff)){
        $_SESSION['errors']['staff_name']="Staff_Name is required";
    }
    if(empty($role_staff)){
        $_SESSION['errors']['staff_role']="Staff_Role is required";
    }

    if(empty($_SESSION['errors'])){
        $sql_check_staff_name_exist="SELECT * FROM staff WHERE `name`=?";
        $stmt=$conn->prepare($sql_check_staff_name_exist);
        $stmt->bind_param("s",$name_staff);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['errors']['staff_name']="This Name is exist already!";
        }else{
            $sql_add_new_staff="INSERT INTO staff (`name`,`role`) VALUES (?,?)";
            $stmt=$conn->prepare($sql_add_new_staff);
            $stmt->bind_param("ss",$name_staff,$role_staff);
            if($stmt->execute()){
                $_SESSION['success_msg']="The staff has been added successfully.";
            }
        }
    }
    header("Location: ./staff.php");
    exit;
}
?>