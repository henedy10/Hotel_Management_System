<?php
    $sql_update="
            UPDATE rooms r
            LEFT JOIN (
                SELECT room_id , COUNT(*) AS total_booked
                FROM room_booking
                WHERE check_out >= CURDATE()
                GROUP BY room_id
            ) b
            ON r.id = b.room_id
            SET r.NumberBooked = COALESCE(b.total_booked, 0);
        ";
    $conn->query($sql_update);

    
?>