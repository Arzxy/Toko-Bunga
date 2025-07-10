<?php
    include "../koneksi.php";
    include "cek_session.php";

	
	//POST UPDATE PRODUK
	if (isset($_POST['namalengkapbaru'])) {
		$userid = $_POST['userid'];
		$namalengkapbaru = $_POST['namalengkapbaru'];
		$notelpbaru = $_POST['notelpbaru'];
		$alamatbaru = $_POST['alamatbaru'];
		$emailbaru = $_POST['emailbaru'];

		$execute = mysqli_query($conn, "UPDATE login SET namalengkap='$namalengkapbaru',notelp='$notelpbaru',alamat='$alamatbaru',email='$emailbaru' WHERE userid='$userid'");
		$_SESSION['info'] = [
            'status' => 'success',
            'message' => "User berhasil diperbaharui!"
        ];
		session_write_close();
		header("location: user_pelanggan.php");
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
								<li class="breadcrumb-item active" aria-current="page">Kelola User/Akun</li>
								<li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
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
										<th>Nama Pelanggan</th>
										<th>Telepon</th>
										<th>Alamat</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * from login where role='Member' order by userid ASC");
										$no=1;
										while($p = mysqli_fetch_array($query)) {
									?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php echo $p['namalengkap'] ?></td>
										<td><?php echo $p['notelp'] ?></td>
										<td><?php echo $p['alamat'] ?></td>
										<td><?php echo $p['email'] ?></td>
										<td>
											<div class="d-flex align-items-center gap-3 fs-6">
												<span data-bs-toggle="modal" data-bs-target="#exampleScrollableModalEdit">
													<a href="?id=<?php echo $p['userid']?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
												</span>
												<a href="user_pelanggan_action_delete.php?id=<?php echo $p['userid']?>" onclick="return confirm('Yakin Hapus Data Ini ?')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
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

		<?php
			if(isset($_GET['id'])) {
				$id = $_GET['id'];
				$execute = mysqli_query($conn, "SELECT * FROM login WHERE userid = '$id'");
				$data = mysqli_fetch_array($execute);
		?>
	   	<div class="modal fade show" id="exampleScrollableModalEdit" tabindex="-1" aria-hidden="false" style="display: block;">
			<div class="modal-dialog modal-dialog-scrollable">
				<form class="modal-content" method="POST" action="">
					<div class="modal-header">
						<h5 class="modal-title">Edit User Pelanggan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input value="<?php echo $data['userid']?>" type="hidden" name="userid" class="form-control">
						<div class="mb-3">
							<label class="form-label">Nama Lengkap:</label>
							<input type="search" class="form-control" value="<?php echo $data['namalengkap']; ?>" name="namalengkapbaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Telepon:</label>
							<input type="search" class="form-control" value="<?php echo $data['notelp']; ?>" name="notelpbaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Alamat Lengkap:</label>
							<input type="search" class="form-control" value="<?php echo $data['alamat']; ?>" name="alamatbaru" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Email:</label>
							<input type="email" class="form-control" value="<?php echo $data['email']; ?>" name="emailbaru" required>
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