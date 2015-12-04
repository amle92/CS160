<?php
$conn = mysqli_connect("localhost", "root", "");
    mysqli_set_charset($conn, "utf8");      
    if (!$conn) {
        die("Database connection failed: " . mysqli_error());
    } else {
        $db_select = mysqli_select_db($conn, "moocs160");
        if (!$db_select) {
            //die("Database selection failed: " . mysqli_error($conn));
        }
    }
?>