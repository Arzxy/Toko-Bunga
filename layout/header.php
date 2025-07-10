    <?php
    if(isset($_SESSION['id'])) {
        $uidd = $_SESSION['id'];
        $qwerty = mysqli_query($conn,"SELECT c.*, count(d.detailid) as jumlahtrans from cart c join detailorder d on c.orderid = d.orderid where c.userid='$uidd' and c.status='Cart'");
        $data = mysqli_fetch_assoc($qwerty);
        if($data['jumlahtrans'] >= 1) {
            $jum_cart = $data['jumlahtrans'];
        } else {
            $jum_cart = "0";
        }
    } else {
        $jum_cart = "0";
    }
    ?>
    <header class="main-header-area">
        <!-- Main Header Area Start -->
        <div class="main-header header-sticky">
            <div class="container custom-area">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-xl-2 col-md-6 col-6 col-custom">
                        <div class="header-logo d-flex align-items-center">
                            <a href="index.php">
                                <img class="img-full" style="width: 80px!important;" src="assets/images/logo_e-bunga.png" alt="Header Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-lg-flex justify-content-center col-custom">
                        <nav class="main-nav d-none d-lg-flex">
                            <ul class="nav">
                                <li>
                                    <a href="index.php">
                                        <span class="menu-text"> Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="kategori.php">
                                        <span class="menu-text"> Kategori</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cart.php">
                                        <span class="menu-text"> Keranjang</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="orderlist.php">
                                        <span class="menu-text"> Daftar Order</span>
                                    </a>
                                </li>
                                <?php if(!isset($_SESSION['username'])) { ?>
                                <li>
                                    <a href="login.php">
                                        <span class="menu-text"> Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="register.php">
                                        <span class="menu-text"> Register</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li>
                                    <a href="">
                                        <span class="menu-text"> <?php echo $_SESSION['username'] ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="logout.php">
                                        <span class="menu-text"> Logout</span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6 col-custom">
                        <div class="header-right-area main-nav">
                            <ul class="nav">
                                <li class="minicart-wrap">
                                    <a href="cart.php" class="minicart-btn toolbar-btn">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="cart-item_count"><?php echo $jum_cart ?></span>
                                    </a>
                                </li>
                                <li class="mobile-menu-btn d-lg-none">
                                    <a class="off-canvas-btn" href="#">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Header Area End -->
        <!-- off-canvas menu start -->
        <aside class="off-canvas-wrapper" id="mobileMenu">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="btn-close-off-canvas">
                    <i class="fa fa-times"></i>
                </div>
                <div class="off-canvas-inner">
                    <!-- mobile menu start -->
                    <div class="mobile-navigation">
                        <!-- mobile menu navigation start -->
                        <nav>
                            <ul class="mobile-menu">
                                <li>
                                    <a href="index.php">
                                        <span class="menu-text"> Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="kategori.php">
                                        <span class="menu-text"> Kategori</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cart.php">
                                        <span class="menu-text"> Keranjang</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="orderlist.php">
                                        <span class="menu-text"> Daftar Order</span>
                                    </a>
                                </li>
                                <?php if(!isset($_SESSION['username'])) { ?>
                                <li>
                                    <a href="login.php">
                                        <span class="menu-text"> Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="register.php">
                                        <span class="menu-text"> Register</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li>
                                    <a href="">
                                        <span class="menu-text"> <?php echo $_SESSION['username'] ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="logout.php">
                                        <span class="menu-text"> Logout</span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                </div>
            </div>
        </aside>
        <!-- off-canvas menu end -->
    </header>