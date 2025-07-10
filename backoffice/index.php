<?php
    include "../koneksi.php";
    include "cek_session.php";
    
    //PAKE YANG INI WORTH IT
    $brg=mysqli_query($conn,"SELECT * from cart where status='Selesai' order by idcart desc");
    $total_pendapatan=0;
    while($b=mysqli_fetch_array($brg)){
        $orderidss = $b['orderid'];
        $querrys = mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidss' and d.idproduk=p.idproduk order by d.idproduk ASC");
        while($bas = mysqli_fetch_array($querrys)){
            if($bas['flashsale'] == 1) {
            $total_pendapatan += $bas['hargaafter'] * $bas['qty'];
            } else {
            $total_pendapatan += $bas['hargabefore'] * $bas['qty'];
            }
        }
    }
    // $query = mysqli_query($conn, "SELECT SUM(d.qty*p.hargaafter) AS harga FROM cart c JOIN detailorder d ON c.orderid = d.orderid JOIN produk p ON d.idproduk = p.idproduk WHERE c.status='Selesai'");
    // $total_pendapatan=0;
    // while($p = mysqli_fetch_array($query)) {
    //   $total_pendapatan += $p['harga'];
    // }
    $query = mysqli_query($conn, "SELECT * from cart where status='Payment'");
    $pending=0;
    while($p = mysqli_fetch_array($query)) {
      $pending++;
    }
    $query = mysqli_query($conn, "SELECT * from cart where status='Confirmed' OR status='Pengiriman'");
    $confirmed=0;
    while($p = mysqli_fetch_array($query)) {
      $confirmed++;
    }
    $query = mysqli_query($conn, "SELECT * from cart where status='Selesai'");
    $selesai=0;
    while($p = mysqli_fetch_array($query)) {
      $selesai++;
    }
    $query = mysqli_query($conn, "SELECT * from cart where status='Batal/Return'");
    $batal=0;
    while($p = mysqli_fetch_array($query)) {
      $batal++;
    }
    $query = mysqli_query($conn, "SELECT * from produk");
    $produk=0;
    while($p = mysqli_fetch_array($query)) {
      $produk++;
    }
    $query = mysqli_query($conn, "SELECT * from login");
    $users=0;
    while($p = mysqli_fetch_array($query)) {
      $users++;
    }
    $query = mysqli_query($conn, "SELECT * from total_pengunjung");
    $total_pengunjung=0;
    while($p = mysqli_fetch_array($query)) {
      $total_pengunjung++;
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
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
              <div class="col">
                <div class="card radius-10 bg-primary">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Pesanan Pending</p>
                        <h4 class="mb-0 text-white"><?php echo $pending ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-bag-fill"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-orange">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Pesanan Diproses</p>
                        <h4 class="mb-0 text-white"><?php echo $confirmed ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-bag-fill"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-success">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Pesanan Selesai</p>
                        <h4 class="mb-0 text-white"><?php echo $selesai ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-bag-fill"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-danger">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Pesanan Direffund</p>
                        <h4 class="mb-0 text-white"><?php echo $batal ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-bag-fill"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-info">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Total Pendapatan</p>
                        <h4 class="mb-0 text-white">Rp. <?php echo number_format($total_pendapatan, 0,',','.') ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-wallet"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-pink">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Total Pengunjung</p>
                        <h4 class="mb-0 text-white"><?php echo $total_pengunjung ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-bar-chart-fill"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-purple">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Total Produk</p>
                        <h4 class="mb-0 text-white"><?php echo $produk ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-box"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10 bg-primary">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-1 text-white">Total User/Akun</p>
                        <h4 class="mb-0 text-white"><?php echo $users ?></h4>
                      </div>
                      <div class="ms-auto widget-icon bg-white-1 text-white">
                        <i class="bi bi-person"></i>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
            </div><!--end row-->

            <!-- <div class="row">
              <div class="col-12 col-lg-12 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Recent Orders</h5>
                      </div>
                     </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table align-middle mb-0">
                        <thead class="table-light">
                          <tr>
                            <th>#ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>#89742</td>
                            <td>
                              <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                   <img src="assets/images/products/11.png" alt="">
                                </div>
                                <div class="product-info">
                                  <h6 class="product-name mb-1">Smart Mobile Phone</h6>
                                </div>
                              </div>
                            </td>
                            <td>2</td>
                            <td>$214</td>
                            <td>Apr 8, 2021</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>#68570</td>
                            <td>
                              <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                   <img src="assets/images/products/07.png" alt="">
                                </div>
                                <div class="product-info">
                                  <h6 class="product-name mb-1">Sports Time Watch</h6>
                                </div>
                              </div>
                            </td>
                            <td>1</td>
                            <td>$185</td>
                            <td>Apr 9, 2021</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>#38567</td>
                            <td>
                              <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                   <img src="assets/images/products/17.png" alt="">
                                </div>
                                <div class="product-info">
                                  <h6 class="product-name mb-1">Women Red Heals</h6>
                                </div>
                              </div>
                            </td>
                            <td>3</td>
                            <td>$356</td>
                            <td>Apr 10, 2021</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>#48572</td>
                            <td>
                              <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                   <img src="assets/images/products/04.png" alt="">
                                </div>
                                <div class="product-info">
                                  <h6 class="product-name mb-1">Yellow Winter Jacket</h6>
                                </div>
                              </div>
                            </td>
                            <td>1</td>
                            <td>$149</td>
                            <td>Apr 11, 2021</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>#96857</td>
                            <td>
                              <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                   <img src="assets/images/products/10.png" alt="">
                                </div>
                                <div class="product-info">
                                  <h6 class="product-name mb-1">Orange Micro Headphone</h6>
                                </div>
                              </div>
                            </td>
                            <td>2</td>
                            <td>$199</td>
                            <td>Apr 15, 2021</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-12 col-xl-4 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent border-0">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h6 class="mb-0">Top Sold</h6>
                      </div>
                     </div>
                  </div>
                  <div class="card-body p-0">
                     <div class="best-product p-2 mb-3">
                       <div class="best-product-item">
                         <div class="d-flex align-items-center gap-3">
                           <div class="product-box border">
                              <img src="assets/images/products/01.png" alt="">
                           </div>
                           <div class="product-info flex-grow-1">
                            <div class="progress-wrapper">
                              <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;"></div>
                              </div>
                            </div>
                             <p class="product-name mb-0 mt-2 fs-6">White Polo T-Shirt <span class="float-end">245</span></p>
                           </div>
                         </div>
                       </div>
                       <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/02.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Black Coat Pant <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/03.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Blue Shade Jeans <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/04.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 50%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Yellow Winter Jacket <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/05.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 40%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Men Sports Shoes Nike <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/06.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 30%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Fancy Home Sofa <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/07.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 20%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Sports Time Watch <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/08.png" alt="">
                          </div>
                          <div class="product-info flex-grow-1">
                           <div class="progress-wrapper">
                             <div class="progress" style="height: 5px;">
                               <div class="progress-bar bg-primary" role="progressbar" style="width: 10%;"></div>
                             </div>
                           </div>
                            <p class="product-name mb-0 mt-2 fs-6">Women Blue Heals <span class="float-end">245</span></p>
                          </div>
                        </div>
                      </div>
                     </div>
                  </div>
                </div>

              </div>
            </div>end row -->


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
  <script src="assets/plugins/chartjs/js/Chart.min.js"></script>
  <script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
  <script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
  <!--app-->
  <script src="assets/js/app.js"></script>
  <script src="assets/js/index.js"></script>
  <script>
    new PerfectScrollbar(".best-product")
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

</html>