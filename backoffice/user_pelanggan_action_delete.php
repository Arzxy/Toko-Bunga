<?php
    include "../koneksi.php";

    $id = $_GET['id'];

    $execute = mysqli_query($conn, "DELETE FROM login WHERE userid = '$id'");
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "User berhasil dihapus!"
    ];
    session_write_close();
    header("location: user_pelanggan.php");
?>