<?php
    include "../koneksi.php";

    $id = $_GET['id'];

    $execute = mysqli_query($conn, "DELETE FROM produk WHERE idproduk = '$id'");
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Produk berhasil dihapus!"
      ];
      session_write_close();
    header("location: produk.php");
?>