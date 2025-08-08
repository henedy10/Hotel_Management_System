<?php 
require "../csrf.php";
require "../database/config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id_edit=$_POST['id_update'];
    $RoomTypeEdit=$_POST['room_type_edit'];
    $BedTypeEdit=$_POST['bed_type_edit'];
    $RoomRentEdit=$_POST['room_rent_edit'];
    $BedRentEdit=$_POST['bed_rent_edit'];
    $NoRoomsEdit=$_POST['no_rooms_edit'];
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF IS INVALID!");
    }
    if(empty($RoomTypeEdit)){
        $_SESSION['errors_edit']['typeroom']="You must select value for room";
    }
    if(empty($BedTypeEdit)){
        $_SESSION['errors_edit']['typebed']="You must select value for bed";
    }
    if(empty($RoomRentEdit)){
        $_SESSION['errors_edit']['rentroom']="You must input value for rent room";
    }else if(!preg_match('/^[0-9]+$/',$RoomRentEdit)){
        $_SESSION['errors_edit']['rentroom']="Numbers is allowed only for rent room!";
    }
    if(empty($BedRentEdit)){
        $_SESSION['errors_edit']['rentbed']="You must input value for rent bed";
    }else if(!preg_match('/^[0-9]+$/',$BedRentEdit)){
        $_SESSION['errors_edit']['rentbed']="Numbers is allowed only for rent bed!";
    }

    if(empty($_SESSION['errors_edit'])){
        $sql_update_room="UPDATE rooms SET room_type=? , bed_type=?,room_rent=?,bed_rent=?,NumberRooms=? WHERE id=?";
        $stmt=$conn->prepare($sql_update_room);
        $stmt->bind_param("ssiiii",$RoomTypeEdit,$BedTypeEdit,$RoomRentEdit,$BedRentEdit,$NoRoomsEdit,$id_edit);
        if($stmt->execute()){
            $_SESSION['success_msg']="Room is updated successfully!";
            header("Location: ./room.php");
            exit();
        }else{
            $_SESSION['failure_edit_msg']="There is an error . $stmt->error";
            header("Location: ./roomedit.php");
        }
    }else{
        header("Location: ./roomedit.php");
        exit();
    }
    $conn->close();
}
?>