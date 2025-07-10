<?php
    include "../koneksi.php";
    include "cek_session.php";

	//POST TAMBAH PRODUK
	if (isset($_POST['tambahnamametode'])) {
		$tambahnamametode = $_POST['tambahnamametode'];
		$tambahnorek = $_POST['tambahnorek'];
		$tambahatasnama = $_POST['tambahatasnama'];
		$sumber = $_FILES['tambahgambar']['tmp_name'];
		$nama_file = $_FILES['tambahgambar']['name'];
		$pindah = move_uploaded_file($sumber, '../images/' . $nama_file);
  
		if ($pindah) {
		  $direct = "images/" . $nama_file;
		} else {
		  $direct = "";
		}
  
		$execute = mysqli_query($conn, "INSERT INTO pembayaran (metode,norek,logo,an) VALUES ('$tambahnamametode','$tambahnorek','$direct','$tambahatasnama')");
		$_SESSION['info'] = [
			'status' => 'success',
			'message' => "Metode pembayaran berhasil ditambahkan!"
		];
		session_write_close();
		header("location: metode-pembayaran.php");
	}

	//POST UPDATE PRODUK
	if (isset($_POST['namametodebaru'])) {
		$no = $_POST['no'];
		$namametodebaru = $_POST['namametodebaru'];
		$norekbaru = $_POST['norekbaru'];
		$atasnamabaru = $_POST['atasnamabaru'];
		if(!$_FILES['gambarbaru']['name']) {
			$direct = $_POST['gambarlama'];
		} else {
			$sumber = $_FILES['gambarbaru']['tmp_name'];
			$nama_file = $_FILES['gambarbaru']['name'];
			$pindah = move_uploaded_file($sumber, '../images/' . $nama_file);
			
			if ($pindah) {
			  $direct = "images/" . $nama_file;
			} else {
			  $direct = "";
			}
		}
  
		$execute = mysqli_query($conn, "UPDATE pembayaran SET metode='$namametodebaru',norek='$norekbaru',logo='$direct',an='$atasnamabaru' WHERE no='$no'");
		$_SESSION['info'] = [
			'status' => 'success',
			'message' => "Metode pembayaran berhasil diperbaharui!"
		];
		session_write_close();
		header("location: metode-pembayaran.php");
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
								<li class="breadcrumb-item active" aria-current="page">Kelola Toko</li>
								<li class="breadcrumb-item active" aria-current="page">Metode Pembayaran</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
					<div class="card-body">
						<div class="col-12">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleScrollableModal"><i class="bi bi-plus-square-fill"></i>&ensp;Tambah Pembayaran</button>
						</div>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Metode</th>
										<th>No. Rekening</th>
										<th>Atas Nama</th>
										<th>Gambar</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * from pembayaran order by no ASC");
										$no=1;
										while($p = mysqli_fetch_array($query)) {
										$id = $p['no'];
									?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php echo $p['metode'] ?></td>
										<td><?php echo $p['norek'] ?></td>
										<td><?php echo $p['an'] ?></td>
										<td><img src="../<?php echo $p['logo'] ?>" width="100" alt="E-BUNGA"></td>
										<td>
											<div class="d-flex align-items-center gap-3 fs-6">
												<span data-bs-toggle="modal" data-bs-target="#exampleScrollableModalEdit">
													<a href="?id=<?php echo $p['no']?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
												</span>
												<a href="metode-pembayaran_action_delete.php?id=<?php echo $p['no']?>" onclick="return confirm('Yakin Hapus Data Ini ?')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
											</div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
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
						<h5 class="modal-title">Tambah Pembayaran</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Nama Metode:</label>
							<input type="search" class="form-control" name="tambahnamametode" required>
						</div>
						<div class="mb-3">
							<label class="form-label">No. Rekening:</label>
							<input type="search" class="form-control" name="tambahnorek" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Atas Nama:</label>
							<input type="search" class="form-control" name="tambahatasnama" required>
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
				$execute = mysqli_query($conn, "SELECT * FROM pembayaran WHERE no = '$id'");
				$data = mysqli_fetch_array($execute);
		?>
	   	<div class="modal fade show" id="exampleScrollableModalEdit" tabindex="-1" aria-hidden="false" style="display: block;">
			<div class="modal-dialog modal-dialog-scrollable">
				<form class="modal-content" method="POST" action="" enctype="multipart/form-data">
					<div class="modal-header">
						<h5 class="modal-title">Edit Pembayaran</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input value="<?php echo $data['no']?>" type="hidden" name="no" class="form-control">
						<div class="mb-3">
							<label class="form-label">Nama Metode:</label>
							<input type="search" class="form-control" value="<?php echo $data['metode']; ?>" name="namametodebaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">No. Rekening:</label>
							<input type="search" class="form-control" value="<?php echo $data['norek']; ?>" name="norekbaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Atas Nama:</label>
							<input type="search" class="form-control" value="<?php echo $data['an']; ?>" name="atasnamabaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Gambar:</label>
							<input type="file" class="form-control" name="gambarbaru" accept="image/*">
							<input value="<?php echo $data['logo']?>" type="hidden" name="gambarlama" class="form-control">
							<img class="mt-3" src="../<?php echo $data['logo'] ?>" width="70" alt="">
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
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
	
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