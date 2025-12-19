<!-- ================================================
     FILE: navbar.html / navbar.blade.php
     FUNGSI: Navbar POLOS (STATIC TEMPLATE)
     ================================================ -->

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand text-primary" href="#">
            <i class="bi bi-bag-heart-fill me-2"></i>
            TokoOnline
        </a>

        <!-- Toggle Mobile -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- Search -->
            <form class="d-flex mx-auto" style="max-width: 400px; width: 100%;">
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Cari produk...">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Katalog -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-grid me-1"></i> Katalog
                    </a>
                </li>

                <!-- Wishlist -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="bi bi-heart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle
                            badge rounded-pill bg-danger"
                            style="font-size: 0.6rem;">
                            3
                        </span>
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="bi bi-cart3"></i>
                        <span class="position-absolute top-0 start-100 translate-middle
                            badge rounded-pill bg-primary"
                            style="font-size: 0.6rem;">
                            2
                        </span>
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="#"
                       data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=User"
                             class="rounded-circle me-2"
                             width="32" height="32">
                        <span class="d-none d-lg-inline">User</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-bag me-2"></i> Pesanan Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-primary" href="#">
                                <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
