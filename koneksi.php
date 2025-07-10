<?php
    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "toko-main";

    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword,  $dbname);

    if(!$conn) {
        die("Koneksi error : " . mysqli_connect_error());
    }
?>