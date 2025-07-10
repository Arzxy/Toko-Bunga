<?php
    include "koneksi.php";
    include "backoffice/cek_session.php";

	$uid = $_SESSION['id'];
	$query = mysqli_query($conn,"SELECT * from cart where userid='$uid' and status='Cart'");
	$data = mysqli_fetch_array($query);
    $count = mysqli_num_rows($query);
    if ($count > 0) {
	    $orderidd = $data['orderid'];
    } else {
        $orderidd = NULL;
    }
    
    $querrys = mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
    $subtotal = 0;
    while($b = mysqli_fetch_array($querrys)){
        if($b['flashsale'] == 1) {
        $subtotal += $b['hargaafter'] * $b['qty'];
        } else {
        $subtotal += $b['hargabefore'] * $b['qty'];
        }
    }
    
    
    //POST UPDATE & DELETE PRODUK
    if (isset($_POST['updateproduk'])) {
        $idproduknya = $_POST['idproduknya'];
        $jumlahproduk = $_POST['jumlahproduk'];
    
        $q1 = mysqli_query($conn, "update detailorder set qty='$jumlahproduk' where idproduk='$idproduknya' and orderid='$orderidd'");
        $_SESSION['info'] = [
            'status' => 'success',
            'message' => "Produk berhasil di update!"
        ];
		session_write_close();
        header("Refresh:0");
    } else if (isset($_POST['hapusproduk'])) {
        $idproduknya = $_POST['idproduknya'];

        $q2 = mysqli_query($conn, "delete from detailorder where idproduk='$idproduknya' and orderid='$orderidd'");
        $_SESSION['info'] = [
            'status' => 'success',
            'message' => "Produk berhasil di hapus!"
        ];
		session_write_close();
        header("Refresh:0");
    }
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/flosun/flosun/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:26 GMT -->
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
                        <h3 class="title-3">Keranjang</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Keranjang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper mt-no-text">
        <div class="container custom-area">
            <div class="row">
                <div class="col-lg-12 col-custom">
                    <!-- Cart Table Area -->
                    <div class="cart-table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Produk</th>
                                    <th class="pro-title">Nama Produk</th>
                                    <th class="pro-quantity">Jumlah</th>
                                    <th class="pro-subtotal">Harga Satuan</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
                                    $no=1;
                                    while($b=mysqli_fetch_array($brg)){
                                ?>
                                <tr>
                                    <td class="pro-thumbnail"><a href=""><img class="img-fluid" src="<?php echo $b['gambar'] ?>" alt="Product" /></a></td>
                                    <td class="pro-title"><a href=""><?php echo $b['namaproduk'] ?></a></td>
                                    <form action="" method="POST">
                                        <td class="pro-quantity">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <input name="jumlahproduk" class="cart-plus-minus-box" min="1" value="<?php echo $b['qty'] ?>" type="number">
                                                    <div class="dec qtybutton">-</div>
                                                    <div class="inc qtybutton">+</div>
                                                    <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                                    <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </td>
                                        <?php if($b['flashsale'] == 1) {?>
                                        <td class="pro-subtotal"><span>Rp. <?php echo number_format($b['hargaafter'], 0,',','.') ?></span></td>
                                        <td class="pro-subtotal"><span>Rp. <?php echo number_format(($b['hargaafter']*$b['qty']), 0,',','.') ?></span></td>
                                        <?php } else { ?>
                                        <td class="pro-subtotal"><span>Rp. <?php echo number_format($b['hargabefore'], 0,',','.') ?></span></td>
                                        <td class="pro-subtotal"><span>Rp. <?php echo number_format(($b['hargabefore']*$b['qty']), 0,',','.') ?></span></td>
                                        <?php } ?>
                                        <td class="pro-remove">
                                            <input type="hidden" name="idproduknya" value="<?php echo $b['idproduk'] ?>">
                                            <input type="submit" name="updateproduk" class="btn flosun-button primary-btn rounded-0 black-btn" value="Update">
                                            <input type="submit" name="hapusproduk" class="btn flosun-button primary-btn rounded-0 black-btn" value="Hapus">
                                        </td>
                                    </form>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Cart Update Option -->
                    <div class="cart-update-option d-block d-md-flex justify-content-between">
                        <div class="apply-coupon-wrapper">
                            <!-- <form action="#" method="post" class=" d-block d-md-flex">
                                <input type="text" placeholder="Enter Your Coupon Code" required />
                                <button class="btn flosun-button primary-btn rounded-0 black-btn">Apply Coupon</button>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $qwerty = mysqli_query($conn,"SELECT c.*, count(d.detailid) as jumlahtrans from cart c join detailorder d on c.orderid = d.orderid where c.userid='$uidd' and c.status='Cart'");
            $data = mysqli_fetch_assoc($qwerty);
            if($data['jumlahtrans'] != 0) {
            ?>
            <div class="row">
                <div class="col-lg-5 ml-auto col-custom">
                    <!-- Cart Calculation Area -->
                    <div class="cart-calculator-wrapper">
                        <div class="cart-calculate-items">
                            <h3>Cart Totals</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>Rp. <?php echo number_format($subtotal, 0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Harga Ongkir</td>
                                        <td>Rp 10.000</td>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <td class="total-amount">Rp. <?php echo number_format($subtotal+10000, 0,',','.') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <a href="checkout.php" class="btn flosun-button primary-btn rounded-0 black-btn w-100">Buat Pesanan!</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- cart main wrapper end -->
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


<!-- Mirrored from htmldemo.net/flosun/flosun/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:26 GMT -->
</html>