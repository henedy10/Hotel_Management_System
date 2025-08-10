<?php 
require __DIR__ ."/roomadd.php";
$sql_select_all_rooms="SELECT * FROM rooms GROUP BY room_type,bed_type";
$result=$conn->query($sql_select_all_rooms);
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/room.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">

        <h2 class="text-2xl font-bold bg-green-500 text-white text-center py-4">Room List</h2>

        <form action="./roomadd.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-300">
            <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
        <!-- Room Type Select -->
            <div>
                <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                <select name="room_type" id="room_type" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400">
                    <option value="" selected>Select Room Type</option>
                    <option value="Guest House">Guest House</option>
                    <option value="Single Room">Single Room</option>
                    <option value="Deluxe Room">Deluxe Room</option>
                    <option value="Superior Room">Superior Room</option>
                    <!-- زود اختيارات لو حابب -->
                </select>
                <label for="room_rent" class="block text-sm font-medium text-gray-700 mb-1">Room Rent</label>
                <input type="number" name="room_rent" id="room_rent" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400" placeholder="Input Room Rent">
            </div>

            <!-- Bed Type Select -->
            <div>
                <label for="bed_type" class="block text-sm font-medium text-gray-700 mb-1">Bed Type</label>
                <select name="bed_type" id="bed_type" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400">
                    <option value="" selected>Select Bed Type</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <option value="Quad">Quad</option>
                    <!-- زود اختيارات لو حابب -->
                </select>
                <label for="bed_rent" class="block text-sm font-medium text-gray-700 mb-1">Bed Rent</label>
                <input type="number" name="bed_rent" id="bed_rent" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-400" placeholder="Input Bed Rent">                
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded">
                    Add Room
                </button>
            </div>
        </form>
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4">
                <?php 
                    echo $_SESSION['success_msg']; 
                    unset($_SESSION['success_msg']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
                <?php 
                    foreach ($_SESSION['errors'] as $error) {
                        echo "<p>$error</p>";
                    }
                    unset($_SESSION['errors']);
                ?>
            </div>
        <?php endif; ?>
        <!-- ✅ Room Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-300">
                <thead class="bg-green-200 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-3 border border-gray-300 text-left">Type Room</th>
                        <th class="px-6 py-3 border border-gray-300 text-left">Room Rent</th>
                        <th class="px-6 py-3 border border-gray-300 text-left">Type Bed</th>
                        <th class="px-6 py-3 border border-gray-300 text-left">Bed Rent</th>
                        <th class="px-6 py-3 border border-gray-300 text-left">No Rooms</th>
                        <th class="px-6 py-3 border border-gray-300 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 text-base">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="odd:bg-green-50 even:bg-green-100 hover:bg-green-200 transition-colors">
                            <td class="px-6 py-4 border border-gray-300"><?php echo htmlspecialchars(strip_tags($row['room_type'])); ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo htmlspecialchars(strip_tags($row['room_rent'])); ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo htmlspecialchars(strip_tags($row['bed_type'])); ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo htmlspecialchars(strip_tags($row['bed_rent'])); ?></td>
                            <td class="px-6 py-4 border border-gray-300"><?php echo htmlspecialchars(strip_tags($row['NumberRooms'])); ?></td>
                            <td class="px-6 py-4 border border-gray-300">
                                <div class="flex justify-evenly">
                                    <form action="./roomdelete.php" method="POST" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <button 
                                                type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 mb-1">
                                                Delete
                                        </button>
                                    </form>
                                    <form action="./roomedit.php" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo GenerateCsrfToken(); ?>">
                                        <input type="hidden" name="id_edit" value="<?php echo $row['id'] ?>">
                                        <button
                                                type="submit"
                                                name="edit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                                                Edit
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure to delete it?");
    }
</script>
</html>

