<?php 
require "../database/config.php";

$sql_count_staff="SELECT * FROM staff";
$result_count_staff=$conn->query($sql_count_staff);
$num_staff=$result_count_staff->num_rows;

$sql_count_room= "SELECT SUM(NumberRooms) as num FROM rooms";
$result_count_room=$conn->query($sql_count_room);
$num_room=$result_count_room->fetch_assoc();

$sql_count_room_booked="SELECT * FROM room_booking";
$result_count_room_booked=$conn->query($sql_count_room_booked);
$num_room_booked=$result_count_room_booked->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dashboard.css">
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- morish bar -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <title>BlueBird - Admin </title>
</head>
<body>
    <div class="databox">
      <div class="box roombox">
        <h2>Total Room</h1>  
        <h1><?php echo $num_room['num'] ?></h1>
      </div>
      <div class="box roombookbox">
        <h2>Total Booked Room</h1>  
        <h1><?php echo $num_room_booked ?></h1>
      </div>
      <div class="box guestbox">
        <h2>Total Staff</h1>  
        <h1><?php echo $num_staff ?></h1>
      </div>
    </div>
</body>



<script>
        const labels = [
          'Superior Room',
          'Deluxe Room',
          'Guest House',
          'Single Room',
        ];
      
        const data = {
          labels: labels,
          datasets: [{
            label: 'My First dataset',
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderColor: 'black',
            data: [],
          }]
        };
  
        const doughnutchart = {
          type: 'doughnut',
          data: data,
          options: {}
        };
        
      const myChart = new Chart(
      document.getElementById('bookroomchart'),
      doughnutchart);
</script>

<script>
Morris.Bar({
 element : 'profitchart',
 data:[<?php echo $chart_data;?>],
 xkey:'date',
 ykeys:['profit'],
 labels:['Profit'],
 hideHover:'auto',
 stacked:true,
 barColors:[
  'rgba(153, 102, 255, 1)',
 ]
});
</script>

</html>