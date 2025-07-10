<?php
    include "koneksi.php";
    session_start();

    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM produk where idproduk='$id'");
    $p = mysqli_fetch_array($query);

    if($p['rate'] == 5) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'; }
    elseif($p['rate'] == 4) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>'; }
    elseif($p['rate'] == 3) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
    elseif($p['rate'] == 2) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
    elseif($p['rate'] == 1) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }

    //POST TAMBAH PRODUK
    if (isset($_POST['tambahidproduk'])) {

        $idproduk = $_POST['tambahidproduk'];
        $jumlahproduk = $_POST['tambahjumlah'];
        $uid = $_SESSION['id'];
        $query = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
        $data = mysqli_fetch_array($query);
        $count = mysqli_num_rows($query);
        $orid = $data['orderid'];

        //kalo ternyata udh ada order id nya
        if ($count > 0) {
            //cek barang serupa
            $cekbrg = mysqli_query($conn,"select * from detailorder where idproduk='$idproduk' and orderid='$orid'");
            $liatlg = mysqli_num_rows($cekbrg);
            $brpbanyak = mysqli_fetch_array($cekbrg);

            //kalo ternyata barangnya udh ada
            if($liatlg > 0){
                $baru = $brpbanyak['qty'] + $jumlahproduk;
                $updateaja = mysqli_query($conn,"update detailorder set qty='$baru' where orderid='$orid' and idproduk='$idproduk'");
            } else {
                $tambahdata = mysqli_query($conn,"insert into detailorder (orderid,idproduk,qty) values('$orid','$idproduk','$jumlahproduk')");
            }
            $_SESSION['info'] = [
                'status' => 'success',
                'message' => "Produk berhasil ditambahkan!"
            ];
            session_write_close();
            header("location: cart.php");

        } else {
            //kalo belom ada order id nya
            $oi = crypt(rand(22,999),time());
            $bikincart = mysqli_query($conn,"insert into cart (orderid, userid) values('$oi','$uid')");
            if ($bikincart) {
                $tambahuser = mysqli_query($conn,"insert into detailorder (orderid,idproduk,qty) values('$oi','$idproduk','$jumlahproduk')");
            }
            $_SESSION['info'] = [
                'status' => 'success',
                'message' => "Produk berhasil ditambahkan!"
            ];
            session_write_close();
            header("location: cart.php");
            
        }
    }

?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/product-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:18 GMT -->
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
                        <h3 class="title-3">Product Details</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Product Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <!-- Single Product Main Area Start -->
    <div class="single-product-main-area">
        <div class="container container-default custom-area">
            <div class="row">
                <div class="col-lg-5 offset-lg-0 col-md-8 offset-md-2 col-custom">
                    <div class="product-details-img">
                        <div class="single-product-img swiper-container gallery-top popup-gallery">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a class="w-100" href="<?php echo $p['gambar'] ?>">
                                        <img class="w-100" src="<?php echo $p['gambar'] ?>" alt="Product">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-custom">
                    <div class="product-summery position-relative">
                        <div class="product-head mb-3">
                            <h2 class="product-title"><?php echo $p['namaproduk'] ?></h2>
                        </div>
                        <div class="price-box mb-2">
                            <?php if($p['flashsale'] == 1) {?>
                            <span class="regular-price">Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></span>
                            <span class="old-price"><del>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></del></span>
                            <?php } else { ?>
                            <span class="regular-price">Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span>
                            <?php } ?>
                        </div>
                        <div class="product-rating mb-3">
                            <?php echo $ratedd ?>
                        </div>
                        <p class="desc-content mb-5"><?php echo $p['deskripsi'] ?></p>
                        <form method="POST" action="" class="quantity-with_btn mb-5">
                            <div class="quantity">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" name="tambahjumlah" min="1" value="1" type="number">
                                    <div class="dec qtybutton">-</div>
                                    <div class="inc qtybutton">+</div>
                                </div>
                            </div>
                            <div class="add-to_cart">
                                <input type="hidden" name="tambahidproduk" value="<?php echo $id ?>">
                                <?php if(isset($_SESSION['id'])) { ?>
                                <button type="submit" class="btn product-cart button-icon flosun-button dark-btn">Beli Sekarang</button>
                                <?php } else { ?>
                                <a href="login.php" class="btn product-cart button-icon flosun-button dark-btn">Beli Sekarang</a>
                                <?php } ?>
                            </div>
                        </form>
                        <div class="social-share mb-4">
                            <span>Bagikan Ke :</span>
                            <a target="_blank" href="https://facebook.com/"><i class="fa fa-facebook-square facebook-color"></i></a>
                            <a target="_blank" href="https://x.com/"><i class="fa fa-twitter-square twitter-color"></i></a>
                            <a target="_blank" href="https://id.linkedin.com/"><i class="fa fa-linkedin-square linkedin-color"></i></a>
                        </div>
                        <div class="payment">
                            <?php
                                $query = mysqli_query($conn, "SELECT * from pembayaran order by no ASC");
                                while($p = mysqli_fetch_array($query)) {
                            ?>
                            <img class="border" src="<?php echo $p['logo'] ?>" width="100" alt="E-BUNGA">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product Main Area End -->
    <!--Product Area Start-->
    <div class="product-area mt-text-3">
        <div class="container custom-area-2 overflow-hidden">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12 col-custom">
                    <div class="section-title text-center mb-30">
                        <span class="section-title-1">The Most Trendy</span>
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
                                if($p['rate'] == 5) { $rateda = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'; }
                                elseif($p['rate'] == 4) { $rateda = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 3) { $rateda = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 2) { $rateda = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                                elseif($p['rate'] == 1) { $rateda = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
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
                                            <?php echo $rateda ?>
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


<!-- Mirrored from htmldemo.net/flosun/flosun/product-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:25 GMT -->
</html>