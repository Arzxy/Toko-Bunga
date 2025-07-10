    <!--start top header-->
    <header class="top-header">        
    <nav class="navbar navbar-expand gap-3">
        <div class="mobile-toggle-icon fs-3">
            <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar-right ms-auto">
            <ul class="navbar-nav align-items-center">
            <li class="nav-item search-toggle-icon">
                <a class="nav-link" href="#">
                <div class="">
                    <i class="bi bi-search"></i>
                </div>
                </a>
            </li>
            <li class="nav-item dropdown dropdown-user-setting">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                <div class="user-setting d-flex align-items-center">
                <img src="assets/images/avatars/avatar-1.png" class="user-img" alt="">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                        <img src="assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="54" height="54">
                        <div class="ms-3">
                        <h6 class="mb-0 dropdown-user-name"><?php echo $_SESSION['username'] ?></h6>
                        <small class="mb-0 dropdown-user-designation text-secondary">Administrator</small>
                        </div>
                    </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="logout.php">
                        <div class="d-flex align-items-center">
                        <div class=""><i class="bi bi-lock-fill"></i></div>
                        <div class="ms-3"><span>Logout</span></div>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            </ul>
            </div>
    </nav>
    </header>
    <!--end top header-->

    <!--start sidebar -->
    <aside class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
        <div>
            <img src="assets/images/logo_e-bunga.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">E-BUNGA</h4>
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
        <li>
            <a href="index.php">
            <div class="parent-icon"><i class="bi bi-gear"></i>
            </div>
            <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="../">
            <div class="parent-icon"><i class="bi bi-shop"></i>
            </div>
            <div class="menu-title">Kembali ke Toko</div>
            </a>
        </li>
        <li class="menu-label">MANAGEMENT</li>
        <li>
            <a href="pesanan.php">
            <div class="parent-icon"><i class="bi bi-cart3"></i>
            </div>
            <div class="menu-title">Kelola Pesanan</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-journal-plus"></i>
            </div>
            <div class="menu-title">Kelola Toko</div>
            </a>
            <ul>
            <li> <a href="kategori.php"><i class="bi bi-circle"></i>Kategori</a>
            </li>
            <li> <a href="produk.php"><i class="bi bi-circle"></i>Produk</a>
            </li>
            <li> <a href="metode-pembayaran.php"><i class="bi bi-circle"></i>Metode Pembayaran</a>
            </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-person"></i>
            </div>
            <div class="menu-title">Kelola User/Akun</div>
            </a>
            <ul>
            <li> <a href="user_pelanggan.php"><i class="bi bi-circle"></i>Pelanggan</a>
            </li>
            <li> <a href="user_admin.php"><i class="bi bi-circle"></i>Administrator</a>
            </li>
            </ul>
        </li>
        <li>
            <a href="logout.php">
            <div class="parent-icon"><i class="bi bi-box-arrow-left"></i>
            </div>
            <div class="menu-title">Logout</div>
            </a>
        </li>
        </ul>
        <!--end navigation-->
    </aside>
    <!--end sidebar -->