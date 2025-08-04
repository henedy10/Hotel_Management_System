<?php 
session_start();
require "../database/config.php";
$sql_select_room_booked="SELECT * FROM room_booking";
$result=$conn->query($sql_select_room_booked);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<!-- css for table and search bar -->
	<link rel="stylesheet" href="css/roombook.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <div class="roombooktable" class="table-responsive-xl">

        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Bed Type</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
					<th scope="col">No of Day</th>
					<th scope="col">Meal Type</th>
                    <th scope="col">Room Rent</th>
                    <th scope="col">Bed Rent</th>
                    <th scope="col">Meals Rent</th>
					<th scope="col">Total Bill</th>
                </tr>
            </thead>

            <tbody class="text-gray-800 text-base">
                    <?php while($row=$result->fetch_assoc()): ?>
                        <?php
                            $check_in=new DateTime($row['check_in']);
                            $check_out=new DateTime($row['check_out']);
                            $diff=$check_out->diff($check_in);
                            $DaysBetweenThem=$diff->days;

                            // fetch the rent of room and bed 

                            $sql_bed_room_rent="SELECT room_rent,bed_rent FROM rooms WHERE room_type=? AND bed_type=? ";
                            $stmt_bed_room_rent=$conn->prepare($sql_bed_room_rent);
                            $stmt_bed_room_rent->bind_param("ss",$row['room_type'],$row['bed_type']);
                            $stmt_bed_room_rent->execute();
                            $result_bed_room_rent=$stmt_bed_room_rent->get_result();
                            $row_bed_room_rent=$result_bed_room_rent->fetch_assoc();

                            // fetch the rent of meal

                            $sql_meal_rent="SELECT price FROM meals WHERE `name`=?";
                            $stmt_meal_rent=$conn->prepare($sql_meal_rent);
                            $stmt_meal_rent->bind_param("s",$row['meal']);
                            $stmt_meal_rent->execute();
                            $result_meal_rent=$stmt_meal_rent->get_result();
                            $row_meal_rent=$result_meal_rent->fetch_assoc();
                        ?>
                        <tr class="odd:bg-green-50 even:bg-green-100 hover:bg-green-200 transition-colors">
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['guest_name'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['room_type'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['bed_type'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['check_in'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['check_out'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $DaysBetweenThem ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row['meal'] ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row_bed_room_rent['room_rent']??"This room no longer exists."?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row_bed_room_rent['bed_rent']??"This bed no longer exists." ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo $row_meal_rent['price']??"This meal no longer exists." ?></td>
                            <td class="px-6 py-4 border border-gray-300">
                                <?php
                                if(isset($row_bed_room_rent['room_rent'])&&isset($row_bed_room_rent['bed_rent']))
                                    echo $row_meal_rent['price']+$row_bed_room_rent['bed_rent']+$row_bed_room_rent['room_rent'] ;
                                else
                                    echo "_";
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    //search bar logic using js
    const searchFun = () =>{
        let filter = document.getElementById('search_bar').value.toUpperCase();

        let myTable = document.getElementById("table-data");

        let tr = myTable.getElementsByTagName('tr');

        for(var i = 0; i< tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[1];

            if(td){
                let textvalue = td.textContent || td.innerHTML;

                if(textvalue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }
        }

    }

</script>

</html>