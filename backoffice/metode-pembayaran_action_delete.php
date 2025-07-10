<?php
    include "../koneksi.php";

    $id = $_GET['id'];

    $execute = mysqli_query($conn, "DELETE FROM pembayaran WHERE no = '$id'");

    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Metode pembayaran berhasil dihapus!"
    ];
    session_write_close();
    header("location: metode-pembayaran.php");
?>