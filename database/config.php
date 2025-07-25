<?php 
$ServerName='localhost';
$UserName='ahmed';
$Password='';
$DataBaseName='hotel_blue_bird';

$conn= new mysqli($ServerName,$UserName,$Password,$DataBaseName);
if($conn->error){
    echo "Your connection is failed ".$conn->error;
}

