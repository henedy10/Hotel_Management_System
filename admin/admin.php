<?php 
session_start();
if(!isset($_SESSION['admin_name'])|| !isset($_SESSION['admin_email'])){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    <!-- loading bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="../css/flash.css">
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>BlueBird - Admin</title>
</head>

<body>
    <!-- mobile view -->
    <div id="mobileview">
        <h5>Admin panel doesn't show in mobile view</h4>
    </div>
    <!-- nav bar -->
    <nav class="uppernav">
        <div class="logo">
            <img class="bluebirdlogo" src="../image/bluebirdlogo.png" alt="logo">
            <p>BLUEBIRD</p>
        </div>
        <div class="logout">
        <a href="./logout.php"><button class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="../image/icon/dashboard.png">&nbsp&nbsp&nbsp Dashboard</li>
            <li class="pagebtn"><img src="../image/icon/bed.png">&nbsp&nbsp&nbsp Room Booking</li>
            <li class="pagebtn"><img src="../image/icon/wallet.png">&nbsp&nbsp&nbsp Payment</li>            
            <li class="pagebtn"><img src="../image/icon/bedroom.png">&nbsp&nbsp&nbsp Rooms</li>
            <li class="pagebtn"><img src="../image/icon/staff.png">&nbsp&nbsp&nbsp Staff</li>
            <li class="pagebtn"><img src="../image/meal.jpg">&nbsp&nbsp&nbsp Meals</li>
        </ul>
    </nav>

    <!-- main section -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="./dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="./roombooking/roombook.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="./payment.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./rooms/room.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./staff/staff.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./meal/meal.php" frameborder="0"></iframe>
    </div>
</body>

<script src="./javascript/script.js"></script>

</html>
