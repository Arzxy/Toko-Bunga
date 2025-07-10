<?php
    include "koneksi.php";
    session_start();
    if (isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }

    //POST TAMBAH AKUN
    if (isset($_POST['email'])) {
        $namalengkap = $_POST['namalengkap'];
        $notelp = $_POST['notelp'];
        $alamatlengkap = $_POST['alamatlengkap'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //CEK DULU ADA EMAIL YANG SAMA ATAU ENGGA!
        $executeed = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
        $count = mysqli_num_rows($executeed);
        if ($count == 1) {
            $_SESSION['info'] = [
                'status' => 'failed',
                'message' => "Email sudah pernah di Daftarkan!"
            ];
            session_write_close();
        } else {
            $execute = mysqli_query($conn, "INSERT INTO login (namalengkap,email,password,notelp,alamat,role) VALUES ('$namalengkap','$email','$password','$notelp','$alamatlengkap','Member')");
            
            if($execute) {
                $executeed = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
                $datas = mysqli_fetch_array($executeed);

                $_SESSION['id'] = $datas['userid'];
                $_SESSION['username'] = $_POST['namalengkap'];
                $_SESSION['notelp'] = $_POST['notelp'];
                $_SESSION['role'] = $datas['role'];
                $_SESSION['log'] = "Logged";
            }
            $_SESSION['info'] = [
                'status' => 'success',
                'message' => "Akun berhasil dibuat dan telah login!"
            ];
            session_write_close();
            header("location: index.php");
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:27 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>E-BUNGA</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo_e-bunga.png">

    <!-- CSS
	============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="assets/css/vendor/font.awesome.min.css">
    <!-- Linear Icons CSS -->
    <link rel="stylesheet" href="assets/css/vendor/linearicons.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css">
    <!-- Jquery ui CSS -->
    <link rel="stylesheet" href="assets/css/plugins/jquery-ui.min.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="assets/css/plugins/nice-select.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">

</head>

<body>

    <!-- Header Area Start Here -->
    <?php include "layout/header.php"; ?>
    <!-- Header Area End Here -->
    <!-- Breadcrumb Area Start Here -->
    <div class="breadcrumbs-area position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="breadcrumb-content position-relative section-content">
                        <h3 class="title-3">Register</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <!-- Register Area Start Here -->
    <div class="login-register-area mt-no-text">
        <div class="container container-default-2 custom-area">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-custom">
                    <div class="login-register-wrapper">
                        <div class="section-content text-center mb-5">
                            <h2 class="title-4 mb-2">Create Account</h2>
                            <p class="desc-content">Please Register using account detail bellow.</p>
                        </div>
                        <form action="" method="POST">
                            <p class="desc-content">Informasi Biodata</p>
                            <div class="single-input-item mb-3">
                                <input type="text" name="namalengkap" placeholder="Nama lengkap" maxlength="50" required>
                            </div>
                            <div class="single-input-item mb-3">
                                <input type="text" name="notelp" placeholder="Nomor telepon" maxlength="15" required>
                            </div>
                            <div class="single-input-item mb-3">
                                <textarea style="width: 100%; " name="alamatlengkap" rows="10" placeholder="Masukkan alamat lengkap untuk pengiriman (termasuk jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kode pos)"></textarea>
                            </div>
                            <p class="desc-content">Informasi Login</p>
                            <div class="single-input-item mb-3">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="single-input-item mb-3">
                                <input type="password" name="password" placeholder="Enter your Password" maxlength="150" required>
                            </div>
                            <div class="single-input-item mb-3">
                                <button class="btn flosun-button secondary-btn theme-color rounded-0">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Area End Here -->
    <!--Footer Area Start-->
    <?php include "layout/footer.php"; ?>
    <!--Footer Area End-->

    <!-- JS
============================================ -->


    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- jQuery Migrate JS -->
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>


    <!-- Swiper Slider JS -->
    <script src="assets/js/plugins/swiper-bundle.min.js"></script>
    <!-- nice select JS -->
    <script src="assets/js/plugins/nice-select.min.js"></script>
    <!-- Ajaxchimpt js -->
    <script src="assets/js/plugins/jquery.ajaxchimp.min.js"></script>
    <!-- Jquery Ui js -->
    <script src="assets/js/plugins/jquery-ui.min.js"></script>
    <!-- Jquery Countdown js -->
    <script src="assets/js/plugins/jquery.countdown.min.js"></script>
    <!-- jquery magnific popup js -->
    <script src="assets/js/plugins/jquery.magnific-popup.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    
    <!-- JS Libraies -->
    <script src="assets/modules/izitoast/js/iziToast.min.js"></script>

    <!-- Page Specific JS File -->
    <?php
    if (isset($_SESSION['info'])) :
        if ($_SESSION['info']['status'] == 'success') {
    ?>
        <script>
            iziToast.success({
            title: 'Sukses',
            message: `<?= $_SESSION['info']['message'] ?>`,
            position: 'topCenter',
            timeout: 5000
            });
        </script>
        <?php
          unset($_SESSION['info']);
          $_SESSION['info'] = null;
        } else {
        ?>
        <script>
            iziToast.error({
            title: 'Gagal',
            message: `<?= $_SESSION['info']['message'] ?>`,
            timeout: 5000,
            position: 'topCenter'
            });
        </script>
    <?php
          unset($_SESSION['info']);
          $_SESSION['info'] = null;
        }
    endif;
    ?>
</body>


<!-- Mirrored from htmldemo.net/flosun/flosun/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:27 GMT -->
</html>