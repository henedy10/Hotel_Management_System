<?php 
require __DIR__ ."/../../csrf.php";
require __DIR__ ."/../../database/config.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $typeroom=$_POST['room_type'];
    $typebed=$_POST['bed_type'];
    $rentroom=$_POST['room_rent'];
    $rentbed=$_POST['bed_rent'];
    $csrf_token=htmlspecialchars(strip_tags(GenerateCsrfToken()));
    
    if(!isset($_POST['csrf_token'])|| !hash_equals($csrf_token,$_POST['csrf_token'])){
        die("CSRF is invalid!");
    }
    if(empty($typeroom)){
        $_SESSION['errors']['typeroom']="You must select value for room";
    }
    if(empty($typebed)){
        $_SESSION['errors']['typebed']="You must select value for bed";
    }
    if(empty($rentroom)){
        $_SESSION['errors']['rentroom']="You must input value for rent room";
    }else if(!preg_match('/^[0-9]+$/',$rentroom)){
        $_SESSION['errors']['rentroom']="Numbers is allowed only for rent room!";
    }
    if(empty($typebed)){
        $_SESSION['errors']['rentbed']="You must input value for rent bed";
    }else if(!preg_match('/^[0-9]+$/',$rentbed)){
        $_SESSION['errors']['rentbed']="Numbers is allowed only for rent bed!";
    }

    if(empty($_SESSION['errors'])){
        $sql_check_room_exist="SELECT * FROM rooms WHERE room_type=? AND bed_type=?";
        $stmt=$conn->prepare($sql_check_room_exist);
        $stmt->bind_param("ss",$typeroom,$typebed);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            $new_noRooms=++$row['NumberRooms'];

            $sql_increase_noRooms="UPDATE rooms SET NumberRooms=? WHERE id=?";
            $stmt=$conn->prepare($sql_increase_noRooms);
            $stmt->bind_param("ii",$new_noRooms,$row['id']);
            if($stmt->execute()){
                $_SESSION['success_msg']="The room has been added successfully.";
            }else{
                $_SESSION['failure_msg']="There is an error ".$stmt->error;
            }
        }else{
            $sql_add_room="INSERT INTO rooms (room_type,bed_type,room_rent,bed_rent) VALUES (?,?,?,?)";
            $stmt=$conn->prepare($sql_add_room);
            $stmt->bind_param("ssii",$typeroom,$typebed,$rentroom,$rentbed);
            if($stmt->execute()){
                $_SESSION['success_msg']="The room has been added successfully.";
            }else{
                $_SESSION['failure_msg']="There is an error ".$stmt->error;
            }
        }
    }
    header("Location: ./room.php");
    exit;
}
?>