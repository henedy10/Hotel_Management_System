<?php
session_start();
require "../database/config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $_SESSION['id_meal_edit']=$_POST['id_edit'];
}
    $sql_select_meal='SELECT * FROM meals WHERE id=?';
    $stmt=$conn->prepare($sql_select_meal);
    $stmt->bind_param("i",$_SESSION['id_meal_edit']);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/room.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">

        <h2 class="text-2xl font-bold bg-green-500 text-white text-center py-4">Edit Meal List</h2>  

        <form action="./mealupdate.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-300">
            <div>
                <label for="mealname" class="block text-sm font-medium text-gray-700 mb-1">Name :</label>
                <input type="text" name="mealnameedit" id="mealname"  value="<?php echo $row['name'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400" >
            </div>
            <div>
                <label for="mealprice" class="block text-sm font-medium text-gray-700 mb-1">Price :</label>
                <input type="number" name="mealpriceedit" id="mealprice" min="0"  value="<?php echo $row['price'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400">
            </div>
            <div class="flex items-end">
                <input type="hidden" name="id_update" value="<?php echo $row['id'] ?>">
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded" name="editmeal">Edit Meal</button>
            </div>
        </form>
        <?php if (isset($_SESSION['failure_edit_msg'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
                <?php 
                    echo $_SESSION['failure_edit_msg']; 
                    unset($_SESSION['failure_edit_msg']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors_edit'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
                <?php 
                    foreach ($_SESSION['errors_edit'] as $error) {
                        echo "<p>$error</p>";
                    }
                    unset($_SESSION['errors_edit']);
                ?>
            </div>
        <?php endif; ?>       
    </div>
</body>
</html>