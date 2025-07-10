<?php
    include "../koneksi.php";
    include "cek_session.php";

    $selected_category = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';
    $query_categories = mysqli_query($conn, "SELECT * from kategori");
    if ($selected_category == 'all') {
        $query_products = mysqli_query($conn, "SELECT * FROM produk");
    } else {
        $query_products = mysqli_query($conn, "SELECT * FROM produk WHERE idkategori = '" . $selected_category . "'");
    }

	  //POST TAMBAH PRODUK
    if (isset($_POST['tambahnamaproduk'])) {
      $tambahnamaproduk = $_POST['tambahnamaproduk'];
      $tambahnamakategori = $_POST['tambahnamakategori'];
      $tambahdeskripsi = $_POST['tambahdeskripsi'];
      $tambahrating = $_POST['tambahrating'];
      $tambahhargabefore = $_POST['tambahhargabefore'];
      $tambahhargaafter = $_POST['tambahhargaafter'];
      $tambahflashsale = $_POST['tambahflashsale'];
      $sumber = $_FILES['tambahgambar']['tmp_name'];
      $nama_file = $_FILES['tambahgambar']['name'];
      $pindah = move_uploaded_file($sumber, '../produk/' . $nama_file);

      if ($pindah) {
        $direct = "produk/" . $nama_file;
      } else {
        $direct = "";
      }

      $execute = mysqli_query($conn, "INSERT INTO produk (idkategori,namaproduk,gambar,deskripsi,rate,hargabefore,hargaafter,flashsale) VALUES ('$tambahnamakategori','$tambahnamaproduk','$direct','$tambahdeskripsi','$tambahrating','$tambahhargabefore','$tambahhargaafter','$tambahflashsale')");
      $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Produk berhasil ditambahkan!"
      ];
      session_write_close();
      header("location: produk.php");
    }

	  //POST UPDATE PRODUK
    if (isset($_POST['namaprodukbaru'])) {
      $idproduk = $_POST['idproduk'];
      $namaprodukbaru = $_POST['namaprodukbaru'];
      $deskripsibaru = $_POST['deskripsibaru'];
      $ratingbaru = $_POST['ratingbaru'];
      $hargabeforebaru = $_POST['hargabeforebaru'];
      $hargaafterbaru = $_POST['hargaafterbaru'];
      $flashsalebaru = $_POST['flashsalebaru'];
      if(!$_FILES['gambarbaru']['name']) {
          $direct = $_POST['gambarlama'];
      } else {
          $sumber = $_FILES['gambarbaru']['tmp_name'];
          $nama_file = $_FILES['gambarbaru']['name'];
          $pindah = move_uploaded_file($sumber, '../produk/' . $nama_file);
          
          if ($pindah) {
            $direct = "produk/" . $nama_file;
          } else {
            $direct = "";
          }
      }

      $execute = mysqli_query($conn, "UPDATE produk SET namaproduk='$namaprodukbaru',deskripsi='$deskripsibaru',hargabefore='$hargabeforebaru',hargaafter='$hargaafterbaru',gambar='$direct',flashsale='$flashsalebaru',rate='$ratingbaru' WHERE idproduk='$idproduk'");
      $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Produk berhasil diperbaharui!"
      ];
      session_write_close();
      header("location: produk.php");
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
                    <li class="breadcrumb-item active" aria-current="page">Kelola Toko</li>
                    <li class="breadcrumb-item active" aria-current="page">Produk</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-header py-3"> 
                <div class="row g-3 align-items-center">
                  <div class="col-lg-3 col-md-6 me-auto">
                    <div class="ms-auto position-relative">
                      <div class="col-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleScrollableModal"><i class="bi bi-plus-square-fill"></i>&ensp;Tambah Produk</button>
                      </div>
                      <select class="form-select" onchange="window.location.href='?kategori=' + this.value">
                          <option value="all" <?php echo $selected_category == 'all' ? 'selected' : ''; ?>>All category</option>
                          <?php while ($kategori = mysqli_fetch_array($query_categories)) { ?>
                              <option value="<?php echo $kategori['idkategori']; ?>" <?php echo $selected_category == $kategori['idkategori'] ? 'selected' : ''; ?>>
                                  <?php echo $kategori['namakategori']; ?>
                              </option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                </div>
                <div class="card-body">
                  <div class="product-grid">
                    <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3">
                      <?php
                        $no=1;
                        while($p = mysqli_fetch_array($query_products)) { 
                          if($p['rate'] == 5) { $ratedd = '<i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i>'; }
                          elseif($p['rate'] == 4) { $ratedd = '<i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-secondary"></i>'; }
                          elseif($p['rate'] == 3) { $ratedd = '<i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i>'; }
                          elseif($p['rate'] == 2) { $ratedd = '<i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i>'; }
                          elseif($p['rate'] == 1) { $ratedd = '<i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i><i class="bi bi-star-fill text-secondary"></i>'; }
                      ?>
                      <div class="col">
                        <div class="card border shadow-none mb-0">
                          <div class="card-body text-center">
                            <img src="../<?php echo $p['gambar'] ?>" width="200" height="200" class="img-fluid mb-3" alt=""/>
                            <h6 class="product-title"><?php echo $p['namaproduk'] ?></h6>
                            <?php if($p['flashsale'] == 1) {?>
                            <p class="product-price fs-5 mb-1"><span>Rp. <?php echo number_format($p['hargaafter'], 0,',','.') ?></span></p>
                            <p class="product-price fs-6 mb-1"><del><span>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span></del></p>
                            <?php } else { ?>
                            <p class="product-price fs-5 mb-1"><span>Rp. <?php echo number_format($p['hargabefore'], 0,',','.') ?></span></p>
                            <?php } ?>
                            <div class="rating mb-0">
                              <?php echo $ratedd ?>
                            </div>
                            <div class="actions d-flex align-items-center justify-content-center gap-2 mt-3">
                              <span data-bs-toggle="modal" data-bs-target="#exampleScrollableModalEdit">
                                <a href="?id=<?php echo $p['idproduk']?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i> Edit</a>
                              </span>
                              <a href="produk_action_delete.php?id=<?php echo $p['idproduk']?>" onclick="return confirm('Yakin Hapus Data Ini ?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill"></i> Delete</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div><!--end row-->
                  </div>
                </div>
              </div>
  </main>
      <!--end page main-->
      <!-- SIMPEN SINI AJA MODALNYA MAL -->
      <div class="modal fade" id="exampleScrollableModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <form class="modal-content" method="POST" action="" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Nama Produk:</label>
                  <input type="search" class="form-control" name="tambahnamaproduk" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Nama Kategori:</label>
                  <select class="form-select mb-3" aria-label="Default select example" name="tambahnamakategori" required>
                    <?php
                      $query = mysqli_query($conn, "SELECT * from kategori order by idkategori ASC");
                      while($p = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $p['idkategori'] ?>"><?php echo $p['namakategori'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Deskripsi:</label>
                  <input type="search" class="form-control" name="tambahdeskripsi" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Rating (1-5):</label>
                  <select class="form-select mb-3" aria-label="Default select example" name="tambahrating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Harga Sebelum Diskon:</label>
                  <input type="search" class="form-control" name="tambahhargabefore" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Harga Setelah Diskon:</label>
                  <input type="search" class="form-control" name="tambahhargaafter" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Flashsale:</label>
                  <select class="form-select mb-3" aria-label="Default select example" name="tambahflashsale" required>
                    <option value="0">Tidak Aktif</option>
                    <option value="1">Aktif</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Gambar:</label>
                  <input type="file" class="form-control" name="tambahgambar" accept="image/*" required>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
          </form>
        </div>
      </div>
      
      <?php
			if(isset($_GET['id'])) {
				$id = $_GET['id'];
				$execute = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk = '$id'");
				$data = mysqli_fetch_array($execute);
        if($data['flashsale'] == 0) { $fs = "Tidak Aktif"; }
        if($data['flashsale'] == 1) { $fs = "Aktif"; }
		  ?>
	   	<div class="modal fade show" id="exampleScrollableModalEdit" tabindex="-1" aria-hidden="false" style="display: block;">
			<div class="modal-dialog modal-dialog-scrollable">
				<form class="modal-content" method="POST" action="" enctype="multipart/form-data">
					<div class="modal-header">
						<h5 class="modal-title">Edit Produk</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
            <input value="<?php echo $data['idproduk']?>" type="hidden" name="idproduk" class="form-control">
						<div class="mb-3">
              <label class="form-label">Nama Produk:</label>
							<input type="search" class="form-control" value="<?php echo $data['namaproduk']; ?>" name="namaprodukbaru" required>
						</div>
            <div class="mb-3">
              <label class="form-label">Deskripsi:</label>
              <input type="search" class="form-control" value="<?php echo $data['deskripsi']; ?>" name="deskripsibaru" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Rating (1-5):</label>
              <select class="form-select mb-3" aria-label="Default select example" name="ratingbaru" required>
                <option value="<?php echo $data['rate'] ?>" selected><?php echo $data['rate'] ?> (Selected)</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Harga Sebelum Diskon:</label>
              <input type="search" class="form-control" value="<?php echo $data['hargabefore']; ?>" name="hargabeforebaru" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Harga Setelah Diskon:</label>
              <input type="search" class="form-control" value="<?php echo $data['hargaafter']; ?>" name="hargaafterbaru" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Flashsale:</label>
              <select class="form-select mb-3" aria-label="Default select example" name="flashsalebaru" required>
                <option value="<?php echo $data['flashsale'] ?>" selected><?php echo $fs ?> (Selected)</option>
                <option value="0">Tidak Aktif</option>
                <option value="1">Aktif</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Gambar:</label>
              <input type="file" class="form-control" name="gambarbaru" accept="image/*">
              <input value="<?php echo $data['gambar']?>" type="hidden" name="gambarlama" class="form-control">
              <img class="mt-3" src="../<?php echo $data['gambar'] ?>" width="70" alt="">
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Tambahkan</button>
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

</html>