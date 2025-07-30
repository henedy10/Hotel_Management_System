<?php 

require "../database/config.php";
$sql_room_booked="SELECT * FROM room_booking";
$result=$conn->query($sql_room_booked);

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
    <title>BlueBird - Admin</title>
</head>

<body>
    <div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search..." onkeyup="searchFun()">
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Type of Room</th>
                    <th scope="col">Type of Bed</th>
                    <th scope="col">Meal</th>
                    <th scope="col">Check-In</th>
                    <th scope="col">Check-Out</th>
                    <th scope="col">No of Day</th>
                    <th scope="col" class="action">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800 text-base">
                <?php while($row=$result->fetch_assoc()):?>
                    <?php 
                        $check_in_date= new DateTime($row['check_in']);
                        $check_out_date= new DateTime($row['check_out']);
                        $diff=$check_out_date->diff($check_in_date);
                        $DaysBetweenThem=$diff->days;
                    ?>
                    <tr class="odd:bg-green-50 even:bg-green-100 hover:bg-green-200 transition-colors">
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['guest_name'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['guest_email'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['guest_phone'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['room_type'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['bed_type'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['meal'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['check_in'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $row['check_out'] ?></td>
                        <td class="px-6 py-4 border border-gray-300"><?php echo $DaysBetweenThem ?></td>
                        <td class="px-6 py-4 border border-gray-300">
                            <form action="./roombookdelete.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 mb-1">Delete</button>
                            </form>
                            <form action="./roombookedit.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <button type="submit"   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
<script src="./javascript/roombook.js"></script>
</html>
