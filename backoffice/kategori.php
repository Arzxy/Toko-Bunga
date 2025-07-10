<?php
    include "../koneksi.php";
    include "cek_session.php";
	
	//POST TAMBAH KATEGORI
    if (isset($_POST['tambahkategori'])) {
		
		$nama = $_POST['tambahkategori'];
		$execute = mysqli_query($conn, "INSERT INTO kategori (namakategori) VALUES ('$nama')");
		$_SESSION['info'] = [
			'status' => 'success',
			'message' => "Kategori berhasil ditambahkan!"
		];
		session_write_close();
		header("location: kategori.php");
	}

	//POST UPDATE KATEGORI
    if (isset($_POST['kategoribaru'])) {
		
		$nama = $_POST['kategoribaru'];
		$id = $_POST['idkategori'];
		$execute = mysqli_query($conn, "UPDATE kategori SET namakategori='$nama' WHERE idkategori='$id'");
		$_SESSION['info'] = [
			'status' => 'success',
			'message' => "Kategori berhasil diperbaharui!"
		];
		session_write_close();
		header("location: kategori.php");
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
								<li class="breadcrumb-item active" aria-current="page">Kategori</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
					<div class="card-body">
						<div class="col-12">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleScrollableModal"><i class="bi bi-plus-square-fill"></i>&ensp;Tambah Kategori</button>
						</div>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Kategori</th>
										<th>Jumlah Produk</th>
										<th>Tanggal Dibuat</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * from kategori order by idkategori ASC");
										$no=1;
										while($p = mysqli_fetch_array($query)) {
										$id = $p['idkategori'];
									?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php echo $p['namakategori'] ?></td>
										<td><?php 
									
											$result1 = mysqli_query($conn,"SELECT Count(idproduk) AS count FROM produk p, kategori k where p.idkategori=k.idkategori and k.idkategori='$id' order by idproduk ASC");
											$cekrow = mysqli_num_rows($result1);
											$row1 = mysqli_fetch_assoc($result1);
											$count = $row1['count'];
											if($cekrow > 0){
											echo number_format($count);
											} else {
												echo 'No data';
											}
										?></td>
										<td><?php echo $p['tgldibuat'] ?></td>
										<td>
											<div class="d-flex align-items-center gap-3 fs-6">
												<span data-bs-toggle="modal" data-bs-target="#exampleScrollableModalEdit">
													<a href="?id=<?php echo $p['idkategori']?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
												</span>
												<a href="kategori_action_delete.php?id=<?php echo $p['idkategori']?>" onclick="return confirm('Yakin Hapus Data Ini ?')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
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
				<form class="modal-content" method="POST" action="">
					<div class="modal-header">
						<h5 class="modal-title">Tambah Kategori</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Nama Kategori:</label>
							<input type="search" class="form-control" name="tambahkategori" required>
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
				$execute = mysqli_query($conn, "SELECT * FROM kategori WHERE idkategori = '$id'");
				$data = mysqli_fetch_array($execute);
		?>
	   	<div class="modal fade show" id="exampleScrollableModalEdit" tabindex="-1" aria-hidden="false" style="display: block;">
			<div class="modal-dialog modal-dialog-scrollable">
				<form class="modal-content" method="POST" action="">
					<div class="modal-header">
						<h5 class="modal-title">Edit Kategori</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input value="<?php echo $data['idkategori']?>" type="hidden" name="idkategori" class="form-control">
						<div class="mb-3">
							<label class="form-label">Nama Kategori (Lama):</label>
							<input type="search" class="form-control" value="<?php echo $data['namakategori']; ?>" disabled>
						</div>
						<div class="mb-3">
							<label class="form-label">Nama Kategori (Baru):</label>
							<input type="search" class="form-control" name="kategoribaru" required>
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