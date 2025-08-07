<?php
require "./book_room_by_guest.php";

$sql_select_all_rooms="SELECT distinct(room_type) FROM rooms";
$result_all_rooms=$conn->query($sql_select_all_rooms);

$sql_select_all_beds="SELECT bed_type,room_type FROM rooms GROUP BY bed_type,room_type";
$result_all_beds=$conn->query($sql_select_all_beds);

$sql_select_all_meals="SELECT `name` FROM meals";
$result_all_meals=$conn->query($sql_select_all_meals);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <title>Hotel blue bird</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../admin/css/roombook.css">
</head>

<body>
    <div>
        <form action="./book_room_by_guest.php" method="POST" class="guestdetailpanelform">
            <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
            <div class="head">
                <h3>RESERVATION</h3>
                <a href="../home.php"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name">
                    <input type="email" name="Email" placeholder="Enter Email">
                    <input type="text" name="Phone" placeholder="Enter Phoneno">
                    <?php if (isset($_SESSION['errors_guest_info'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                foreach ($_SESSION['errors_guest_info'] as $error) {
                                    echo "<p>$error</p>";
                                }
                                unset($_SESSION['errors_guest_info']);
                            ?>
                        </div>
                    <?php endif; ?>  
                    <?php if (isset($_SESSION['success_msg'])): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['success_msg']; 
                                unset($_SESSION['success_msg']);
                            ?>
                        </div>
                    <?php endif; ?>                   
                    <?php if (isset($_SESSION['account_exist_msg'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['account_exist_msg']; 
                                unset($_SESSION['account_exist_msg']);
                            ?>
                        </div>
                    <?php endif; ?>                   
                    <?php if (isset($_SESSION['check_order'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                echo $_SESSION['check_order']; 
                                unset($_SESSION['check_order']);
                            ?>
                        </div>
                    <?php endif; ?>                   
                </div>
                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" class="selectinput">
                        <option value selected >Type Of Room</option>
                        <?php while($row_rooms=$result_all_rooms->fetch_assoc()): ?>
                        <option value="<?php echo $row_rooms['room_type'] ?>"><?php echo $row_rooms['room_type'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <select name="Bed" class="selectinput">
                        <option value selected >Bedding Type</option>
                        <?php while($row_beds=$result_all_beds->fetch_assoc()): ?>
                        <option value="<?php echo $row_beds['bed_type'] ?>"><?php echo $row_beds['bed_type'] . " =>" .($row_beds['room_type']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <select name="Meal" class="selectinput">
                        <option value selected >Meal</option>
                        <?php while($row_meals=$result_all_meals->fetch_assoc()): ?>
                        <option value="<?php echo $row_meals['name'] ?>"><?php echo $row_meals['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type ="date">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type ="date">
                        </span>
                    </div>
                    <?php if (isset($_SESSION['errors_reservation_info'])): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 w-full">
                            <?php 
                                foreach ($_SESSION['errors_reservation_info'] as $error) {
                                    echo "<p>$error</p>";
                                }
                                unset($_SESSION['errors_reservation_info']);
                            ?>
                        </div>
                    <?php endif; ?>                       
                </div>
            </div>
            <div class="footer">
                <button id="submitBtn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
            </div>
        </form>
        </div>
    </div>

<script>
    document.getElementById("submitBtn")?.addEventListener("click", function () {
        window.location.href = "page2.php"; // غير الصفحة حسب الحاجة
    });
</script>
</body>

</html>