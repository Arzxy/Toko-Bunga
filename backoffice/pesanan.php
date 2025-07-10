<?php
    include "../koneksi.php";
    include "cek_session.php";
?>
<!doctype html>
<html lang="en" class="light-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/logo_e-bunga.png" type="image/png" />
  <!--plugins-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">


  <!--Theme Styles-->
  <link href="assets/css/dark-theme.css" rel="stylesheet" />
  <link href="assets/css/light-theme.css" rel="stylesheet" />
  <link href="assets/css/semi-dark.css" rel="stylesheet" />
  <link href="assets/css/header-colors.css" rel="stylesheet" />

  <title>E-BUNGA - Admin Panel</title>
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
  	   <?php include('layout/header.php'); ?>
       <!--start content-->
       <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">MANAGEMENT</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bi bi-gear"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Kelola Pesanan</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>ID Pesanan</th>
										<th>Nama Pembeli</th>
										<th>Tanggal Order</th>
										<th>Total</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * from cart c, login l where c.userid=l.userid and status!='Cart' and status!='Selesai' and status!='Payment' and status!='Batal/Return' order by idcart DESC");
										$no=1;
										while($p = mysqli_fetch_array($query)) {
											$orderids = $p['orderid'];

											$querrys = mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderids' and d.idproduk=p.idproduk order by d.idproduk ASC");
											$count = 0;
											while($b = mysqli_fetch_array($querrys)){
												if($b['flashsale'] == 1) {
												$count += $b['hargaafter'] * $b['qty'];
												} else {
												$count += $b['hargabefore'] * $b['qty'];
												}
											}
									?>
										<tr>
											<td><?php echo $no++ ?></td>
											<td><strong><a href="order.php?orderid=<?php echo $p['orderid'] ?>">#<?php echo $p['orderid'] ?></a></strong></td>
											<td><?php echo $p['namalengkap'] ?></td>
											<td><?php echo $p['tglorder'] ?></td>
											<td>Rp. <?php echo number_format($count+10000, 0,',','.') ?></td>
											<?php if($p['status'] != "Pengiriman"){ ?>
											<td>Confirmed</td>
											<?php } else { ?>
											<td>Pengiriman</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</main>
       <!--end page main-->


       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        
  </div>
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="assets/js/pace.min.js"></script>
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
	
  <!--app-->
  <script src="assets/js/app.js"></script>
  
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

</html>