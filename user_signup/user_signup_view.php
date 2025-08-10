<?php 
require __DIR__ ."/../user_signup/user_signup.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Loading Bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="./css/flash.css">
    <title>Sign Up</title>
</head>

<body>
    <!-- Carousel -->
    <section id="carouselExampleControls" class="carousel slide carousel_section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="carousel-image" src="../image/hotel1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel2.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel3.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel4.jpg">
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <section id="auth_section">
        <div class="auth_container">
            <div class="logo">
                <img class="bluebirdlogo" src="../image/bluebirdlogo.png" alt="logo">
                <p>BLUEBIRD</p>
            </div>
            <h2 class="text-center">Sign Up</h2>
                    <div>
                        <p class="text-red-500 text-center">
                            <?php 
                                if(isset($_SESSION['exist_account_msg'])){
                                    echo "* ".$_SESSION['exist_account_msg'];
                                    unset($_SESSION['exist_account_msg']);
                                }
                            ?>
                        </p>
                    </div> 
                    <div>
                        <p class="text-green-500 text-center">
                            <?php 
                                if(isset($_SESSION['success_msg'])){
                                    echo "* ".$_SESSION['success_msg'];
                                    unset($_SESSION['success_msg']);
                                }
                            ?>
                        </p>
                    </div> 
            <div class="flex justify-center">
                <form class="user_signup" id="usersignup" action="./user_signup.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="Username_Signup" placeholder=" ">
                        <label for="Username">Username</label>
                    </div>
                    <div>
                        <p class="flex text-red-500">
                            <?php 
                                if(isset($_SESSION['errors']['user_name_signup'])){
                                    echo "* ".$_SESSION['errors']['user_name_signup'];
                                    unset($_SESSION['errors']['user_name_signup']);
                                }
                            ?>
                        </p>
                    </div>                    
                    <div class="form-floating">
                        <input type="email" class="form-control" name="Email_Signup" placeholder=" ">
                        <label for="Email">Email</label>
                    </div>
                    <div>
                        <p class="flex text-red-500">
                            <?php 
                                if(isset($_SESSION['errors']['user_email_signup'])){
                                    echo "* ".$_SESSION['errors']['user_email_signup'];
                                    unset($_SESSION['errors']['user_email_signup']);
                                }
                            ?>
                        </p>
                    </div>                    
                    <div class="form-floating">
                        <input type="password" class="form-control" name="Password_Signup" placeholder=" ">
                        <label for="Password">Password</label>
                    </div>
                    <div>
                        <p class="flex text-red-500">
                            <?php 
                                if(isset($_SESSION['errors']['user_password_signup'])){
                                    echo "* ".$_SESSION['errors']['user_password_signup'];
                                    unset($_SESSION['errors']['user_password_signup']);
                                }
                            ?>
                        </p>
                    </div>                    
                    <div class="form-floating">
                        <input type="password" class="form-control" name="CPassword_Signup" placeholder=" ">
                        <label for="CPassword">Confirm Password</label>
                    </div>
                    <div>
                        <p class="flex text-red-500">
                            <?php 
                                if(isset($_SESSION['errors']['user_confirm_password_signup'])){
                                    echo "* ".$_SESSION['errors']['user_confirm_password_signup'];
                                    unset($_SESSION['errors']['user_confirm_password_signup']);
                                }
                            ?>
                        </p>
                    </div>                    
                    <button type="submit" name="user_signup_submit" class="auth_btn">Sign up</button>
                    <div class="footer_line">
                        <h6>Already have an account? <span class="page_move_btn"><a href="../index.php">Log in</a></span></h6>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <script src="./javascript/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>