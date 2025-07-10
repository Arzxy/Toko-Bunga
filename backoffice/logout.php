<?php
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['notelp']);
    unset($_SESSION['role']);
    unset($_SESSION['log']);
    session_destroy();
    
    session_start();
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Anda berhasil logout!"
    ];
    session_write_close();
    header("Location: login.php");