<?php
    $sql_update="
            UPDATE rooms r
            LEFT JOIN (
                SELECT room_type, bed_type, COUNT(*) AS total_booked
                FROM room_booking
                GROUP BY room_type, bed_type
            ) b
            ON r.room_type = b.room_type AND r.bed_type = b.bed_type
            SET r.NumberBooked = b.total_booked
        ";
    $conn->query($sql_update);

    
?>