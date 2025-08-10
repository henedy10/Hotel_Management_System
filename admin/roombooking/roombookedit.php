<?php 
require __DIR__ ."/roombookupdate.php";
if($_SERVER['REQUEST_METHOD']=="POST"&&isset($_POST['edit'])){
    $_SESSION['id']=$_POST['id'];
}
$sql_select_booked_room="SELECT * FROM room_booking WHERE id=?";
$stmt=$conn->prepare($sql_select_booked_room);
$stmt->bind_param("i",$_SESSION['id']);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_assoc();

$sql_select_available_rooms="SELECT room_type FROM rooms WHERE NumberRooms>NumberBooked";
$result_all_rooms=$conn->query($sql_select_available_rooms);

$sql_select_available_beds="SELECT bed_type FROM rooms WHERE NumberRooms>NumberBooked";
$result_all_beds=$conn->query($sql_select_available_beds);

$sql_select_available_meals="SELECT * FROM meals";
$result_all_meals=$conn->query($sql_select_available_meals);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/roombook.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #editpanel{
            position : fixed;
            z-index: 1000;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            /* align-items: center; */
            background-color: #00000079;
        }
        #editpanel .guestdetailpanelform{
            height: 620px;
            width: 1170px;
            background-color: #ccdff4;
            border-radius: 10px;  
            /* temp */
            position: relative;
            top: 20px;
            animation: guestinfoform .3s ease;
        }
    </style>
    <title>Edit-Room-Booked</title>
</head>
<body>
    <div id="editpanel">
        <form method="POST"  action="./roombookupdate.php"  class="guestdetailpanelform">
            <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
            <div class="head">
                <h3>EDIT RESERVATION</h3>
                <a href="./roombook.php"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="EditName" placeholder="Enter Full name" value="<?php echo $row['guest_name'] ?>" >
                    <input type="email" name="EditEmail" placeholder="Enter Email" value="<?php echo $row['guest_email'] ?>" >

                    <input type="text" name="EditPhone" placeholder="Enter Phoneno" value="<?php echo $row['guest_phone'] ?>"  >
                    <?php if (isset($_SESSION['errors_guest_info'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                foreach ($_SESSION['errors_edit_guest_info'] as $error) {
                                    echo "<p>$error</p>";
                                }
                                unset($_SESSION['errors_edit_guest_info']);
                            ?>
                        </div>
                    <?php endif; ?>  
                    <?php if (isset($_SESSION['success_edit_msg'])): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['success_edit_msg']; 
                                unset($_SESSION['success_edit_msg']);
                            ?>
                        </div>
                    <?php endif; ?>                   
                    <?php if (isset($_SESSION['edit_account_exist_msg'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['edit_account_exist_msg']; 
                                unset($_SESSION['edit_account_exist_msg']);
                            ?>
                        </div>
                    <?php endif; ?>                     
                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="EditRoomType" class="selectinput">
						<option value="<?php echo $row['room_type'] ?>" selected ><?php echo $row['room_type'] ?> </option>
                        <?php while($row_rooms=$result_all_rooms->fetch_assoc()): ?>
                        <option value="<?php echo $row_rooms['room_type'] ?>"><?php echo $row_rooms['room_type'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <select name="EditBed" class="selectinput">
						<option value="<?php echo $row['bed_type'] ?>" selected ><?php echo $row['bed_type'] ?></option>
                        <?php while($row_beds=$result_all_beds->fetch_assoc()):?>
                        <option value="<?php echo $row_beds['bed_type'] ?>"><?php echo $row_beds['bed_type']?></option>
                        <?php endwhile;?>
                    </select>
                    <select name="EditMeal" class="selectinput">
						<option value="<?php echo $row['meal'] ?>" selected><?php echo $row['meal'] ?></option>
                        <?php while($row_meals=$result_all_meals->fetch_assoc()): ?>
                        <option value="<?php echo $row_meals['name'] ?>"><?php echo $row_meals['name'] ?></option>
                        <?php endwhile; ?>
					</select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="Editcin" type ="date" value="<?php echo $row['check_in'] ?>" >
                        </span>
                        <span>
                            <label for="cout"> Check-Out</label>
                            <input name="Editcout" type ="date" value="<?php echo $row['check_out'] ?>" >
                        </span>
                    </div>
                    <?php if (isset($_SESSION['errors_edit_reservation_info'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                foreach ($_SESSION['errors_edit_reservation_info'] as $error) {
                                    echo "<p>$error</p>";
                                }
                                unset($_SESSION['errors_edit_reservation_info']);
                            ?>
                        </div>
                    <?php endif; ?> 
                    <?php if (isset($_SESSION['check_exist_order'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['check_exist_order']; 
                                unset($_SESSION['check_exist_order']);
                            ?>
                        </div>
                    <?php endif; ?>                           
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailedit" type="submit">Edit</button>
            </div>
        </form>
    </div>
</body>
</html>