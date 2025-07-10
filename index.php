<?php
    include "koneksi.php";
    session_start();
    
    $query = mysqli_query($conn, "SELECT * from produk where flashsale='1'");
    $howmany_flashsale=0;
    while($p = mysqli_fetch_array($query)) {
      $howmany_flashsale++;
    }

    $kkk = $_SERVER['SERVER_ADDR'];
    $tambahkat = mysqli_query($conn,"insert into total_pengunjung (ip) values ('$kkk')");
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:02:30 GMT -->
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
    <!-- Slider/Intro Section Start -->
    <div class="intro11-slider-wrap section-2 mrl-50">
        <div class="intro11-slider swiper-container">
            <div class="swiper-wrapper">
                <div class="intro11-section swiper-slide slide-4 slide-bg-2 bg-position">
                    <!-- Intro Content Start -->
                    <div class="intro11-content-2 text-center">
                        <h1 class="different-title">Selamat Datang</h1>
                        <h2 class="title">2024 E-Bunga</h2>
                        <a href="kategori.php" class="btn flosun-button secondary-btn theme-color rounded-0">Belanja Sekarang</a>
                    </div>
                    <!-- Intro Content End -->
                </div>
                <div class="intro11-section swiper-slide slide-3 slide-bg-2 bg-position">
                    <!-- Intro Content Start -->
                    <div class="intro11-content text-left">
                        <h3 class="title-slider text-uppercase">Tentang Kami</h3>
                        <h2 class="title">Terimakasih sudah <br> mempercayai kami</h2>
                        <p class="desc-content">Kami sangat menghargai kepercayaan yang Anda berikan kepada kami. Dengan dedikasi penuh, kami selalu berusaha memberikan produk dan layanan terbaik untuk memenuhi kebutuhan Anda. Kepuasan Anda adalah prioritas utama kami, dan kami berkomitmen untuk terus berkembang demi melayani Anda lebih baik lagi.</p>
                        <a href="kategori.php" class="btn flosun-button secondary-btn rounded-0">Belanja Sekarang</a>
                    </div>
                    <!-- Intro Content End -->
                </div>
            </div>
            <!-- Slider Navigation -->
            <div class="home1-slider-prev swiper-button-prev main-slider-nav"><i class="lnr lnr-arrow-left"></i></div>
            <div class="home1-slider-next swiper-button-next main-slider-nav"><i class="lnr lnr-arrow-right"></i></div>
            <!-- Slider pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- Slider/Intro Section End -->
    <!--Product Area Start-->
    <div class="product-area mt-text-2 mb-text-3">
        <div class="container custom-area-2 overflow-hidden">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12 col-custom">
                    <div class="section-title text-center mb-30">
                        <span class="section-title-1">Wonderful gift</span>
                        <h3 class="section-title-3">Featured Products</h3>
                    </div>
                </div>
                <!--Section Title End-->
            </div>
            <div class="row product-row">
                <div class="col-12 col-custom">
                    <div class="product-slider swiper-container anime-element-multi">
                        <div class="swiper-wrapper">
                            <?php
                                $query = mysqli_query($conn, "SELECT * from produk where flashsale='0'");
                                $no=1;
                                while($p = mysqli_fetch_array($query)) {
                                if($p['rate'] == 5) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'; }
                                elseif($p['rate'] == 4) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 3) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 2) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 1) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                            ?>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="product-details.php?id=<?php echo $p['idproduk'] ?>">
                                            <img src="<?php echo $p['gambar'] ?>" alt="" class="product-image-1 w-100">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <a href="product-details.php?id=<?php echo $p['idproduk'] ?>"><?php echo $p['namaproduk'] ?></a></h4>
                                        </div>
                                        <div class="product-rating">
                                            <?php echo $ratedd ?>
                                        </div>
                                        <div class="price-box">
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span>
                                        </div>
                                        <a href="product-details.php?id=<?php echo $p['idproduk'] ?>" class="btn product-cart">Tambah Keranjang</a>
                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Slider pagination -->
                        <div class="swiper-pagination default-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Product Area End-->
    <?php if($howmany_flashsale > 0) { ?>
    <!-- Product Countdown Area Start Here -->
    <div class="product-countdown-area product-countdown-style pb-text-4">
        <div class="container custom-area">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12 col-custom">
                    <div class="section-title text-center">
                        <h3 class="section-title-3">Deal of The Month</h3>
                    </div>
                </div>
                <!--Section Title End-->
            </div>
            <div class="row">
                <!--Countdown Start-->
                <div class="col-12 col-custom">
                    <div class="countdown-area">
                        <div class="countdown-wrapper d-flex justify-content-center">
                            <div class="single-countdown">
                                <span class="single-countdown_time days"></span>
                                <span class="single-countdown_text">Days</span>
                            </div>
                            <div class="single-countdown">
                                <span class="single-countdown_time hours">00</span>
                                <span class="single-countdown_text">Hours</span>
                            </div>
                            <div class="single-countdown">
                                <span class="single-countdown_time minutes">00</span>
                                <span class="single-countdown_text">Mins</span>
                            </div>
                            <div class="single-countdown">
                                <span class="single-countdown_time seconds">00</span>
                                <span class="single-countdown_text">Secs</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Countdown End-->
            </div>
            <div class="row product-row">
                <div class="col-12 col-custom">
                    <div class="item-carousel-2 swiper-container anime-element-multi product-area">
                        <div class="swiper-wrapper">
                            <?php
                                $query = mysqli_query($conn, "SELECT * from produk where flashsale='1'");
                                $no=1;
                                while($p = mysqli_fetch_array($query)) {
                                if($p['rate'] == 5) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'; }
                                elseif($p['rate'] == 4) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 3) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 2) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 1) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                            ?>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="product-details.php?id=<?php echo $p['idproduk'] ?>">
                                            <img src="<?php echo $p['gambar'] ?>" alt="" class="product-image-1 w-100">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <a href="product-details.php?id=<?php echo $p['idproduk'] ?>"><?php echo $p['namaproduk'] ?></a></h4>
                                        </div>
                                        <div class="product-rating">
                                            <?php echo $ratedd ?>
                                        </div>
                                        <div class="price-box">
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></span>
                                            <span class="old-price"><del>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></del></span>
                                        </div>
                                        <a href="product-details.php?id=<?php echo $p['idproduk'] ?>" class="btn product-cart">Tambah Keranjang</a>
                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Slider pagination -->
                        <div class="swiper-pagination default-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Countdown Area End Here -->
    <?php } ?>
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

    <?php
        // BUAT DI ARAHIN KE JS DIBAWAH NI COY
        $datess = new DateTime('now');
        $datess->modify('last day of this month 23:59:59');
        $countdownDateTime = $datess->format('Y-m-d H:i:s');
    ?>
    <script>
        function updateTimer() {     
            var countDownDate = new Date("<?php echo $countdownDateTime; ?>").getTime();
            
            function calculateTime() {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                if (distance >= 0) { // Periksa apakah hitung mundur masih valid
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.querySelector(".days").textContent = days;
                    document.querySelector(".hours").textContent = hours;
                    document.querySelector(".minutes").textContent = minutes;
                    document.querySelector(".seconds").textContent = seconds;
                } else {
                    document.getElementById("expired_time_flash_sale").textContent = "Waktu sudah habis!";
                    document.getElementById("expired_time_flash_sale_description").textContent = "Silahkan tunggu ditanggal awal bulan, karena akan ada promo kembali!";
                    document.getElementById("expired_time_flash_sale_tampilan").textContent = "Tidak ada produk yang ditampilkan...";
                }
            }

            calculateTime();
        }

        document.addEventListener("DOMContentLoaded", function() {
            updateTimer();
            setInterval(updateTimer, 1000); // Update timer every second
        });
    </script>
    
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


<!-- Mirrored from htmldemo.net/flosun/flosun/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:05 GMT -->
</html>