<?php
    include "koneksi.php";
    include "backoffice/cek_session.php";

	$uid = $_SESSION['id'];

    //POST TAMBAH PRODUK
    if (isset($_POST['sumberdana'])) {
        $kodeorder = $_POST['kodeorder'];
        $sumberdana = $_POST['sumberdana'];
        $rekeningtujuan = $_POST['rekeningtujuan'];
        $tglbayar = $_POST['tglbayar'];
        $sumber = $_FILES['bukti']['tmp_name'];
        $nama_file = $_FILES['bukti']['name'];
        $pindah = move_uploaded_file($sumber, 'bukti/' . $nama_file);
  
        if ($pindah) {
          $direct = "bukti/" . $nama_file;
        } else {
          $direct = "";
        }

		$executedd = mysqli_query($conn,"UPDATE cart set status='Confirmed' where orderid='$kodeorder'");
        $execute = mysqli_query($conn, "INSERT INTO konfirmasi (orderid,userid,payment,namarekening,tglbayar,gambar) VALUES ('$kodeorder','$uid','$rekeningtujuan','$sumberdana','$tglbayar','$direct')");

        $_SESSION['info'] = [
            'status' => 'success',
            'message' => "Harap tunggu sampai proses selesai!"
        ];
		session_write_close();
        header("location: orderlist.php");
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
                        <h3 class="title-3">Daftar Order</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Daftar Order</li>
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
                                    <th class="pro-thumbnail">No</th>
                                    <th class="pro-title">Kode Order</th>
                                    <th class="pro-quantity">Tanggal Order</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-subtotal">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $brg=mysqli_query($conn,"SELECT * from cart where userid = '$uid' and status!='Cart' order by idcart desc");
                                    $no=1;
                                    while($b=mysqli_fetch_array($brg)){
                                        $orderidss = $b['orderid'];
                                        $querrys = mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidss' and d.idproduk=p.idproduk order by d.idproduk ASC");
                                        $subtotal = 0;
                                        while($bas = mysqli_fetch_array($querrys)){
                                            if($bas['flashsale'] == 1) {
                                            $subtotal += $bas['hargaafter'] * $bas['qty'];
                                            } else {
                                            $subtotal += $bas['hargabefore'] * $bas['qty'];
                                            }
                                        }
                                ?>
                                <tr>
                                    <td class="pro-title"><?php echo $no++ ?></td>
                                    <td class="pro-title"><?php echo $b['orderid'] ?></td>
                                    <td class="pro-title"><?php echo $b['tglorder'] ?></td>
                                    <td class="pro-title">Rp. <?php echo number_format($subtotal+10000, 0,',','.') ?></td>
                                    <?php if($b['status'] == "Payment") { ?>
                                    <td class="pro-title">
                                        <span data-bs-toggle="modal" data-bs-target="#exampleScrollableModalEdit">
                                            <a href="?orderid=<?php echo $b['orderid']?>" class="btn flosun-button primary-btn rounded-0 black-btn">Konfirmasi pembayaran</a>
                                        </span>
                                    </td>
                                    <?php } if($b['status'] == "Confirmed") { ?>
                                    <td class="pro-title">Sedang Diproses</td>
                                    <?php } if($b['status'] == "Pengiriman") { ?>
                                    <td class="pro-title">Sedang Dikirim</td>
                                    <?php } if($b['status'] == "Selesai") { ?>
                                    <td class="pro-title">Pesanan selesai</td>
                                    <?php } if($b['status'] == "Batal/Return") { ?>
                                    <td class="pro-title">Pesanan Dibatalkan, Harap hubungi kami!</td>
                                    <?php } ?>
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
        </div>
    </div>

    <?php
        if(isset($_GET['orderid'])) {
            $orderid = $_GET['orderid'];
            $execute = mysqli_query($conn, "SELECT * FROM cart WHERE orderid = '$orderid' and status='Payment'");
            $data = mysqli_fetch_array($execute);
    ?>
    <div class="modal fade show" id="exampleScrollableModalEdit" tabindex="-1" aria-hidden="false" <?php echo ($data['status'] == 'Payment') ? 'style="display: block;"' : 'style="display: none;"' ?>>
        <div class="modal-dialog modal-dialog-scrollable">
            <form class="modal-content" method="POST" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembayaran #<?php echo $orderid ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Order:</label>
						<input value="<?php echo $orderid ?>" type="hidden" name="kodeorder" class="form-control">
                        <input type="search" class="form-control" value="<?php echo $orderid ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informasi Pembayaran:</label>
                        <input type="search" class="form-control" name="sumberdana" placeholder="Nama Pemilik Rekening / Sumber Dana" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekening Tujuan:</label>
                        <select class="form-select mb-3" aria-label="Default select example" name="rekeningtujuan" required>
                            <?php
                            $query = mysqli_query($conn, "SELECT * from pembayaran order by no ASC");
                            while($p = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?php echo $p['metode'] ?>"><?php echo $p['metode'] ?> (No. Rek: <?php echo $p['norek'] ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar:</label>
                        <input type="date" class="form-control" name="tglbayar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti: <a style="color: red;">(Wajib)</a></label>
                        <input type="file" class="form-control" name="bukti" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn flosun-button primary-btn rounded-0 black-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn flosun-button primary-btn rounded-0 black-btn">Kirim</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <script>
        // Tambahkan auto-close jika tombol close di-click
        document.querySelector('.btn-close').addEventListener('click', function () {
            window.history.pushState({}, '', window.location.pathname); // Hapus parameter GET
        });
    </script>
    <?php } ?>

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

    <script>
	document.addEventListener('DOMContentLoaded', () => {
		const closeButtons = document.querySelectorAll('.btn-close, [data-bs-dismiss="modal"]');

		// Tambahkan event listener ke semua tombol close
		closeButtons.forEach(btn => {
			btn.addEventListener('click', () => {
				// Hapus GET parameter dari URL
				window.history.replaceState({}, document.title, window.location.pathname);

				// Paksa modal untuk tertutup dengan Bootstrap
				const modal = document.getElementById('exampleScrollableModalEdit');
				if (modal) {
					modal.classList.remove('show');
					modal.style.display = 'none';
					const backdrop = document.querySelector('.modal-backdrop');
					if (backdrop) {
						backdrop.remove();
					}
				}
			});
		});
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


<!-- Mirrored from htmldemo.net/flosun/flosun/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 Dec 2022 05:03:26 GMT -->
</html>