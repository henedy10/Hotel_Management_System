<?php 
session_start();
require __DIR__ ."/database/config.php";
if(isset($_SESSION['user_name'])&&isset($_SESSION['user_email'])){
  if(isset($_POST['book'])){
    header("Location: ./user_room_book/roombookconfirm.php");
  }
}else{
  header("Location: ./index.php");
  exit;
}

$sql_select_all_rooms="SELECT * FROM rooms";
$result=$conn->query($sql_select_all_rooms);
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
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <style>
      #guestdetailpanel{
        display: none;
      }
      #guestdetailpanel .middle{
        height: 450px;
      }
    </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img class="bluebirdlogo" src="./image/bluebirdlogo.png" alt="logo">
      <p>BLUEBIRD</p>
    </div>
    <ul>
      <li><a href="#firstsection">Home</a></li>
      <li><a href="#secondsection">Rooms</a></li>
      <li><a href="#thirdsection">Facilites</a></li>
      <li><a href="#contactus">contact us</a></li>
      <a href="./user_log/user_logout.php"><button class="btn btn-danger">Logout</button></a>
    </ul>
  </nav>

  <section id="firstsection" class="carousel slide carousel_section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="carousel-image" src="./image/hotel1.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel2.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel3.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel4.jpg">
        </div>
        <div class="welcomeline">
          <h1 class="welcometag">Welcome to heaven on earth</h1>
        </div>
    </div>
  </section>
  <section id="secondsection"> 
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <img src="./image/homeanimatebg.svg">
        <div class="ourroom">
          <h1 class="head">≼ Our room ≽</h1>
          <div class="roomselect">
            <?php 
              if($result->num_rows>0): 
              while($row=$result->fetch_assoc()):
            ?>
            <div class="roombox">
              <div class="hotelphoto h1"></div>
              <div class="roomdata">
                <h2><?php echo $row['room_type'] ?></h2>
                <div class="services">
                  <i class="fa-solid fa-wifi"></i>
                  <i class="fa-solid fa-burger"></i>
                  <i class="fa-solid fa-spa"></i>
                  <i class="fa-solid fa-dumbbell"></i>
                  <i class="fa-solid fa-person-swimming"></i>
                </div>
                <?php if($row['NumberRooms']>$row['NumberBooked']):?>
                <button type="submit" class="btn btn-primary bookbtn" name="book">Book</button>
                <?php endif;?>
              </div>
            </div>
            <?php endwhile; ?>
            <?php 
              else:
                echo "<p class= text-red-500> There is no rooms now </p>";
              endif;
            ?>
          </div>
        </div>
      </form>
      </section>


  <section id="thirdsection">
    <h1 class="head">≼ Facilities ≽</h1>
    <div class="facility">
      <div class="box">
        <h2>Swiming pool</h2>
      </div>
      <div class="box">
        <h2>Spa</h2>
      </div>
      <div class="box">
        <h2>24*7 Restaurants</h2>
      </div>
      <div class="box">
        <h2>24*7 Gym</h2>
      </div>
      <div class="box">
        <h2>Heli service</h2>
      </div>
    </div>
  </section>

  <section id="contactus">
    <div class="social">
      <a href="https://www.linkedin.com/in/ahmed-faisal-zayed/"><i class="fa-brands fa-linkedin"></i> </a>
      <i class="fa-brands fa-facebook"></i>
      <i class="fa-solid fa-envelope"></i>
    </div>
    <div class="createdby">
      <h5>Created by @ahmedfaisal</h5>
    </div>
  </section>
</body>
</html>