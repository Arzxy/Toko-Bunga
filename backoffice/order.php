<?php
    include "../koneksi.php";
    include "cek_session.php";

    $orderid = $_GET['orderid'];
    $query = mysqli_query($conn, "SELECT k.*, l.*, c.*, d.*, p.logo from konfirmasi k join pembayaran p on k.payment = p.metode join login l on k.userid = l.userid join cart c on k.orderid = c.orderid join detailorder d on d.orderid = c.orderid where k.orderid = '$orderid'");
    $data = mysqli_fetch_array($query);

    $subtotal = 0;

	  //POST UPDATE STATUS
    if (isset($_POST['status'])) {
      if($_POST['status'] == "Barang akan Dikirim") {
        $updatestatus = mysqli_query($conn,"UPDATE cart set status='Pengiriman' where orderid='$orderid'");
        $_SESSION['info'] = [
          'status' => 'success',
          'message' => "Status order berhasil diperbaharui!"
        ];
        session_write_close();
      } elseif($_POST['status'] == "Selesai & Sudah Sampai") {
		    $updatestatus = mysqli_query($conn,"UPDATE cart set status='Selesai' where orderid='$orderid'");
		    $del =  mysqli_query($conn,"DELETE from konfirmasi where orderid='$orderid'");
        $_SESSION['info'] = [
          'status' => 'success',
          'message' => "Status order berhasil diperbaharui!"
        ];
        session_write_close();
        header("location: pesanan.php");
      } elseif($_POST['status'] == "Batal/Return") {
		    $updatestatus = mysqli_query($conn,"UPDATE cart set status='Batal/Return' where orderid='$orderid'");
		    $del =  mysqli_query($conn,"DELETE from konfirmasi where orderid='$orderid'");
        $_SESSION['info'] = [
          'status' => 'success',
          'message' => "Status order berhasil diperbaharui!"
        ];
        session_write_close();
        header("location: pesanan.php");
      }
  
      header("Refresh:0");
    }
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
                      <li class="breadcrumb-item active" aria-current="page">Pesanan Status</li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!--end breadcrumb-->

              <div class="card">
                <div class="card-header py-3"> 
                  <form class="row g-3 align-items-center" method="POST" action="">
                    <div class="col-12 col-lg-4 col-md-6 me-auto">
                      <h5 class="mb-1">
                        <?php
                          $input = $data['tglsubmit'];
                          $date = new DateTime($input);
                          echo $date->format('D, M d, Y, g:iA');
                        ?>
                      </h5>
                      <p class="mb-0">Pesanan ID : #<?php echo $_GET['orderid'] ?></p>
                    </div>
                    <div class="col-12 col-lg-3 col-6 col-md-3">
                      <select class="form-select" name="status">
                        <option value="Barang akan Dikirim">Barang akan Dikirim</option>
                        <option value="Selesai & Sudah Sampai">Selesai & Sudah Sampai</option>
                        <option value="Batal/Return">Batal/Return</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-6 col-md-3">
                       <button type="submit" style="width: 100%!important;" class="btn btn-primary">Perbaharui</button>
                    </div>
                  </form>
                 </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-3">
                       <div class="col">
                         <div class="card border shadow-none radius-10">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div>
                              <div class="info">
                                 <h6 class="mb-2">Nama Pembeli</h6>
                                 <p class="mb-1"><?php echo $data['namalengkap'] ?></p>
                                 <p class="mb-1"><?php echo $data['email'] ?></p>
                                 <p class="mb-1"><?php echo $data['notelp'] ?></p>
                              </div>
                           </div>
                           </div>
                         </div>
                       </div>
                       <div class="col">
                        <div class="card border shadow-none radius-10">
                          <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-danger border-0">
                                <i class="bi bi-geo-alt text-danger"></i>
                              </div>
                              <div class="info">
                                <h6 class="mb-2">Tujuan Pengiriman</h6>
                                <p class="mb-1"><strong>Alamat</strong> : <?php echo $data['alamat'] ?></p>
                                <?php if($data['status'] == "Confirmed") { ?>
                                <p class="mb-1"><strong>Status</strong> : -</p>
                                <?php } elseif($data['status'] == "Pengiriman") { ?>
                                <p class="mb-1"><strong>Status</strong> : Sedang dalam pengiriman...</p>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                         </div>
                       </div>
                  </div><!--end row-->

                  <div class="row">
                      <div class="col-12 col-lg-8">
                         <div class="card border shadow-none radius-10">
                           <div class="card-body">
                               <div class="table-responsive">
                                 <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                     <tr>
                                       <th>Produk</th>
                                       <th>Harga</th>
                                       <th>Jumlah</th>
                                       <th>Total</th>
                                     </tr>
                                   </thead>
                                   <tbody>
                                      <?php
                                        $query = mysqli_query($conn, "SELECT d.*, p.* from detailorder d join produk p on d.idproduk = p.idproduk where orderid = '$orderid' and d.idproduk = p.idproduk order by d.idproduk ASC");
                                        while($p = mysqli_fetch_array($query)) {
                                      ?>
                                     <tr>
                                       <td>
                                         <div class="orderlist">
                                          <a class="d-flex align-items-center gap-2" href="javascript:;">
                                            <div class="product-box">
                                                <img src="../<?php echo $p['gambar'] ?>" alt="">
                                            </div>
                                            <div>
                                                <P class="mb-0 product-title"><?php echo $p['namaproduk'] ?></P>
                                            </div>
                                           </a>
                                         </div>
                                       </td>
                                       <?php if($p['flashsale'] == 0) { ?>
                                       <?php $subtotal += ($p['qty'] * $p['hargabefore']) ?>
                                       <td>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></td>
                                       <td><?php echo $p['qty'] ?></td>
                                       <td>Rp. <?php echo number_format(($p['qty'] * $p['hargabefore']), 0,',','.') ?></td>
                                       <?php } else { ?>
                                       <?php $subtotal += ($p['qty'] * $p['hargaafter']) ?>
                                       <td>Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></td>
                                       <td><?php echo $p['qty'] ?></td>
                                       <td>Rp. <?php echo number_format(($p['qty'] * $p['hargaafter']), 0,',','.') ?></td>
                                       <?Php } ?>
                                     </tr>
                                     <?php } ?>
                                   </tbody>
                                 </table>
                               </div>
                           </div>
                         </div>
                      </div>
                      <div class="col-12 col-lg-4">
                        <div class="card border shadow-none bg-light radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-4">
                                 <div>
                                    <h5 class="mb-0">Rincian Pesanan</h5>
                                 </div>
                                 <div class="ms-auto">
                                   <button type="button" class="btn alert-success radius-30 px-4">Confirmed</button>
                                </div>
                              </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Sub Total</p>
                                </div>
                                <div class="ms-auto">
                                  <h5 class="mb-0">Rp. <?php echo number_format($subtotal, 0,',','.') ?></h5>
                              </div>
                            </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Harga Ongkir</p>
                                </div>
                                <div class="ms-auto">
                                  <h5 class="mb-0">Rp. 10.000</h5>
                              </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center mb-3">
                              <div>
                                <p class="mb-0">Total</p>
                              </div>
                              <div class="ms-auto">
                                <h5 class="mb-0">Rp. <?php echo number_format($subtotal+10000, 0,',','.') ?></h5>
                            </div>
                          </div>
                          </div>
                        </div>

                        <div class="card border shadow-none bg-warning radius-10">
                          <div class="card-body">
                              <h5>Pembayaran</h5>
                               <div class="d-flex align-items-center gap-3">
                                  <div class="fs-2">
                                    <img src="../<?php echo $data['logo'] ?>" width="70" alt="">
                                  </div>
                                  <div class="">
                                    <p class="mb-0 fs-6"><?php echo $data['payment'] ?> </p>
                                  </div>
                               </div>
                              <p>Pemilik Rekening: <?php echo $data['namarekening'] ?> <br>
                                 Tanggal Pembayaran: 
                                 <?php
                                  $input = $data['tglbayar'];
                                  $date = new DateTime($input);
                                  echo $date->format("M d, Y");
                                 ?>
                              </p>
                          </div>
                        </div>


                     </div>
                  </div><!--end row-->

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