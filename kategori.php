<?php
    include "koneksi.php";
    session_start();

    $selected_category = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';
    $query_categories = mysqli_query($conn, "SELECT * from kategori");
    if ($selected_category == 'all') {
        $query_products = mysqli_query($conn, "SELECT * FROM produk");
    } else {
        $query_products = mysqli_query($conn, "SELECT * FROM produk WHERE idkategori = '" . $selected_category . "'");
    }
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/shop.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:17 GMT -->
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
                        <h3 class="title-3">Kategori</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <!-- Shop Main Area Start Here -->
    <div class="shop-main-area">
        <div class="container container-default custom-area">
            <div class="row flex-row-reverse">
                <div class="col-lg-9 col-12 col-custom widget-mt">
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper mb-30">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-3" title="Grid"><i class="fa fa-th"></i></button>
                            <button data-role="grid_list" type="button" class="btn-list" title="List"><i class="fa fa-th-list"></i></button>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <!-- Shop Wrapper Start -->
                    <div class="row shop_wrapper grid_3">
                        <?php
                            while($p = mysqli_fetch_array($query_products)) { 
                            if($p['rate'] == 5) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'; }
                            elseif($p['rate'] == 4) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>'; }
                            elseif($p['rate'] == 3) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                            elseif($p['rate'] == 2) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                            elseif($p['rate'] == 1) { $ratedd = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>'; }
                        ?>
                        <div class="col-md-6 col-sm-6 col-lg-4 col-custom product-area">
                            <div class="product-item">
                                <div class="single-product position-relative mr-0 ml-0">
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
                                            <?php if($p['flashsale'] == 1) {?>
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></span>
                                            <span class="old-price "><del>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></del></span>
                                            <?php } else { ?>
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span>
                                            <?php } ?>
                                        </div>
                                        <a href="product-details.php?id=<?php echo $p['idproduk'] ?>" class="btn product-cart">Tambah Keranjang</a>
                                    </div><div class="product-content-listview">
                                        <div class="product-title">
                                            <h4 class="title-2"> <a href="product-details.php?id=<?php echo $p['idproduk'] ?>"><?php echo $p['namaproduk'] ?></a></h4>
                                        </div>
                                        <div class="product-rating">
                                            <?php echo $ratedd ?>
                                        </div>
                                        <div class="price-box">
                                            <?php if($p['flashsale'] == 1) {?>
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></span>
                                            <span class="old-price "><del>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></del></span>
                                            <?php } else { ?>
                                            <span class="regular-price ">Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span>
                                            <?php } ?>
                                        </div>
                                        <p class="desc-content"><?php echo $p['deskripsi'] ?></p>
                                        <div class="button-listview">
                                            <a href="product-details.php?id=<?php echo $p['idproduk'] ?>" class="btn product-cart button-icon flosun-button dark-btn" data-toggle="tooltip" data-placement="top" title="Tambah ke Keranjang"> <span>Tambah Keranjang</span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Shop Wrapper End -->
                </div>
                <div class="col-lg-3 col-12 col-custom">
                    <!-- Sidebar Widget Start -->
                    <aside class="sidebar_widget widget-mt">
                        <div class="widget_inner">
                            <div class="widget-list widget-mb-1">
                                <h3 class="widget-title">List Kategori</h3>
                                <div class="sidebar-body">
                                    <ul class="sidebar-list">
                                        <li><a href="kategori.php?kategori=all">All Product</a></li>
                                        <?php 
                                        while ($kategori = mysqli_fetch_array($query_categories)) { 
                                        $id = $kategori['idkategori'];
                                        $result1 = mysqli_query($conn,"SELECT Count(idproduk) AS count FROM produk p, kategori k where p.idkategori=k.idkategori and k.idkategori='$id' order by idproduk ASC");
                                        $cekrow = mysqli_num_rows($result1);
                                        $row1 = mysqli_fetch_assoc($result1);
                                        $count = $row1['count'];
                                        ?>
                                        <li><a href="kategori.php?kategori=<?php echo $kategori['idkategori']; ?>"><?php echo $kategori['namakategori']; ?> (<?php echo $count; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Sidebar Widget End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Main Area End Here -->
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


<!-- Mirrored from htmldemo.net/flosun/flosun/shop.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:17 GMT -->
</html>