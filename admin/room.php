<?php 
require "./roomadd.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/room.css">
</head>
<body>
    <div class="addroomsection">
        <form action="./roomadd.php" method="POST">
            <label for="typeroom">Type of Room :</label>
            <select name="typeroom" class="form-control">
                <option value="" selected></option>
                <option value="Superior Room">SUPERIOR ROOM</option>
                <option value="Deluxe Room">DELUXE ROOM</option>
                <option value="Guest House">GUEST HOUSE</option>
                <option value="Single Room">SINGLE ROOM</option>
            </select>

            <label for="bed">Type of Bed :</label>
            <select name="bed" class="form-control">
                <option value="" selected></option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
                <option value="Quad">Quad</option>
            </select>

            <button type="submit" class="btn btn-success">Add Room</button>
        </form>
        <div>
            <p class="text-red-500 text-center">
                <?php 
                    if(isset($_SESSION['errors']['typeroom'])){
                        echo "* ".$_SESSION['errors']['typeroom'];
                        unset($_SESSION['errors']['typeroom']);
                    }else if(isset($_SESSION['errors']['bed'])){
                        echo "* ".$_SESSION['errors']['bed'];
                        unset($_SESSION['errors']['bed']);
                    }
                ?>
            </p>
            <p class="text-green-500 text-center">
                <?php 
                    if(isset($_SESSION['success_msg'])){
                        echo "* ".$_SESSION['success_msg'];
                        unset($_SESSION['success_msg']);
                    }
                ?>
            </p>
        </div> 

    </div>
    <!-- <div class="room">
    </div> -->

</body>

</html>