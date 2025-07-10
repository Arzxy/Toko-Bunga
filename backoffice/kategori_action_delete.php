<?php
    include "../koneksi.php";

    $id = $_GET['id'];

    $execute = mysqli_query($conn, "DELETE FROM kategori WHERE idkategori = '$id'");
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Kategori berhasil dihapus!"
    ];
    session_write_close();
    header("location: kategori.php");
?>