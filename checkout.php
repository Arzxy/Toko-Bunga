<?php
    include "koneksi.php";
    session_start();

	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"SELECT * from cart where userid='$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];

    $querrys = mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
    $subtotal = 0;
    while($b = mysqli_fetch_array($querrys)){
        if($b['flashsale'] == 1) {
        $subtotal += $b['hargaafter'] * $b['qty'];
        } else {
        $subtotal += $b['hargabefore'] * $b['qty'];
        }
    }

    if (isset($_POST['orderid'])) {
		$orderid = $_POST['orderid'];
		$execute = mysqli_query($conn, "UPDATE cart SET status='Payment' WHERE orderid='$orderid'");
        $_SESSION['info'] = [
            'status' => 'success',
            'message' => "Lanjut ke proses selanjutnya!"
        ];
		session_write_close();
		header("location: orderlist.php");
	}
    
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:26 GMT -->
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
                        <h3 class="title-3">Checkout</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <!-- Checkout Area Start Here -->
    <div class="checkout-area mt-no-text">
        <div class="container custom-container">
            <div class="row">
                <div class="col-lg-6 col-12 col-custom">
                    <div class="checkbox-form">
                        <h3>Informasi Pembayaran</h3>
                        <p class="mb-4">Daftar pembayaran yang tersedia di toko kami</p>
                        <div class="row">
                            <?php
                                $query = mysqli_query($conn, "SELECT * from pembayaran order by no ASC");
                                $no=1;
                                while($p = mysqli_fetch_array($query)) {
                                $id = $p['no'];
                            ?>
                            <div class="col-md-12 col-custom">
                                <div class="checkout-form-list create-acc">
                                    <input id="cbox-<?php echo $p['no'] ?>" type="checkbox">
                                    <label for="cbox-<?php echo $p['no'] ?>">Pembayaran via <?php echo $p['metode'] ?></label>
                                </div>
                                <div id="cbox-info-<?php echo $p['no'] ?>" class="checkout-form-list create-account">
                                    <p class="mb-2">Pastikan Anda melakukan pembayaran sesuai dengan tujuan yang tercantum di bawah ini. Kami tidak dapat membantu jika terjadi kesalahan pengiriman</p>
                                    <p class="mb-2">Silakan lakukan pembayaran sesuai dengan pesanan Anda sebesar <strong><span class="amount">Rp. <?php echo number_format($subtotal+10000, 0,',','.') ?></span></strong></p>
                                    <label>No. Rekening <span class="required">*</span></label>
                                    <input class="mb-2" value="<?php echo $p['norek'] ?>" type="text" disabled>
                                    <label>Atas Nama <span class="required">*</span></label>
                                    <input class="mb-4" value="<?php echo $p['an'] ?>" type="text" disabled>
                                    <div><img src="<?php echo $p['logo'] ?>" width="100" alt="E-BUNGA"></div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 col-custom">
                    <div class="your-order">
                        <h3>Pesanan Kamu</h3>
                        <div class="your-order-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name">Product</th>
                                        <th class="cart-product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
                                        $no=1;
                                        while($p = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr class="cart_item">
                                        <td class="cart-product-name"> <?php echo $p['namaproduk'] ?><strong class="product-quantity"> × <?php echo $p['qty'] ?></strong></td>
                                        <?php if($p['flashsale'] == 1) {?>
                                        <td class="cart-product-total text-center"><span class="amount">Rp. <?php echo number_format(($p['hargaafter']*$p['qty']), 0,',','.') ?></span></td>
                                        <?php } else { ?>
                                        <td class="cart-product-total text-center"><span class="amount">Rp. <?php echo number_format(($p['hargabefore']*$p['qty']), 0,',','.') ?></span></td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                    <tr class="cart_item">
                                        <td class="cart-product-name"> Harga Ongkir</td>
                                        <td class="cart-product-total text-center"><span class="amount">Rp. 10.000</span></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td class="text-center"><strong><span class="amount">Rp. <?php echo number_format($subtotal+10000, 0,',','.') ?></span></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <div id="accordion">
                                    <div class="card">
                                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                            <div class="card-body mb-2">
                                                <p>Orderan anda Akan Segera kami proses 1x24 Jam Setelah Anda Melakukan Pembayaran ke ATM kami dan menyertakan informasi pribadi yang melakukan pembayaran seperti Nama Pemilik Rekening / Sumber Dana, Tanggal Pembayaran, Metode Pembayaran dan Jumlah Bayar.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="" class="order-button-payment">
                                    <input value="<?php echo $orderidd ?>" type="hidden" name="orderid" class="form-control">
                                    <button type="submit" class="btn flosun-button secondary-btn black-color rounded-0 w-100">Terima & Sudah Bayar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Area End Here -->
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

    <script>
        <?php
            $query = mysqli_query($conn, "SELECT * from pembayaran order by no ASC");
            $no=1;
            while($p = mysqli_fetch_array($query)) {
        ?>
        $('#cbox-<?php echo $p['no'] ?>').on('click', function () {
            $('#cbox-info-<?php echo $p['no'] ?>').slideToggle(900);
        });
        <?php } ?>
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


<!-- Mirrored from htmldemo.net/flosun/flosun/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:27 GMT -->
</html>