<?php
// Only start the session if one isn't already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['id']);
$fname = $isLoggedIn ? $_SESSION['fname'] : '';
?>
<nav class="header-nav navbar navbar-expand-md shadow-sm">
    <div class="container">
        <button
            type="button"
            class="mobile-menu-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
            id="mobileMenuToggle">
            <i class="bi-list"></i>
        </button>

        <a class="nav-hotel-name" href="../pages/home.php">
            Dockside Hotel
            <sup class="header-c bi-c-circle"></sup>
        </a>
        <!-- TODO: adding active js class depending on page -->
        <div class="collapse navbar-collapse header-menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-link active">Home</li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link"
                        href="#"
                        id="accommodationsDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span>Accommodations
                            <i
                                class="bi-chevron-down d-md-none d-lg-inline d-xl-inline d-xxl-inline"></i></span>
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end rooms-dpd shadow-sm"
                        aria-labelledby="accommodationsDropdown">
                        <li><a class="dropdown-item" href="../pages/accomodations.php?room=presidential">Presidential Suite</a></li>
                        <li><a class="dropdown-item" href="../pages/accomodations.php?room=executive">Executive Suite</a></li>
                        <li><a class="dropdown-item" href="../pages/accomodations.php?room=deluxe">Deluxe Room</a></li>
                        <li><a class="dropdown-item" href="../pages/accomodations.php?room=standard">Standard Room</a></li>
                    </ul>
                </li>
                <li class="nav-link">Facilities</li>
                <li class="nav-link">Events</li>
            </ul>
        </div>

        <div class="dropdown">
            <button
                class="btn user-dpd-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi-person-circle"></i>
                <?php if ($isLoggedIn): ?>
                    <span class="d-none d-lg-inline"><?php echo $fname; ?></span>
                <?php endif; ?>
                <i class="bi-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end user-dpd shadow-sm <?php if ($isLoggedIn): ?>logged-in<?php endif; ?>">
                <div class="dropdown-header <?php if ($isLoggedIn): ?>logged-in<?php endif; ?>">
                    <div class="user-dpd-header-cont">
                        <?php if ($isLoggedIn): ?>
                            <span class="welcome">Welcome back, <?php echo $fname; ?>!</span>
                        <?php else: ?>
                            <span class="welcome mb-3 d-block">Welcome to Dockside Hotel<sup class="header-c">©</sup></span>
                            <a href="../pages/login.php" class="sign-in text-decoration-none">
                                <div class="shadow-sm">Sign In</div>
                            </a>

                            <a href="../pages/sign_up.php" class="join text-decoration-none">
                                <div class="shadow-sm">Join Us</div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <hr class="dropdown-divider" /> <?php if ($isLoggedIn): ?>
                    <a href="../pages/user_dashboard.php#bookings" class="dropdown-item">My Bookings</a>
                    <a href="../pages/user_dashboard.php#history" class="dropdown-item">Booking History</a>
                    <a href="../pages/user_dashboard.php#profile" class="dropdown-item">Profile</a>
                    <a href="../pages/user_dashboard.php#settings" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider" />
                    <a href="../scripts/handle_logout.php" class="dropdown-item text-danger">Logout</a>
                <?php else: ?>
                    <a href="" class="dropdown-item disabled">My Bookings</a>
                    <a href="" class="dropdown-item disabled">Booking History</a>
                    <a href="" class="dropdown-item disabled">Profile</a>
                    <a href="" class="dropdown-item disabled">Settings</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation -->
<div class="mobile-nav" id="mobileSideMenu">
    <div class="mobile-nav-head">
        <button
            type="button"
            class="mobile-menu-close-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
            id="mobileMenuClose">
            <i class="bi-x-lg"></i>
        </button>

        <a class="nav-hotel-name text-center ms-5 mx-5" href="../pages/home.php">
            Dockside Hotel
            <sup class="header-c bi-c-circle"></sup>
        </a>
    </div>
    <ul class="navbar-nav ms-auto">
        <a href="../pages/home.php" class="pt-3">
            <li class="nav-item-1">Home</li>
        </a>
        <hr />
        <li class="nav-item-1">
            <span
                data-bs-toggle="collapse"
                href="#mobileAccommodationsCollapse"
                aria-controls="mobileAccommodationsCollapse">Accommodations
                <i class="bi-chevron-down"></i>
            </span>
            <div class="collapse mob-rooms" id="mobileAccommodationsCollapse">
                <ul class="list-unstyled ps-3">
                    <a href="../pages/accomodations.php?room=presidential">
                        <li>Presidential Suite</li>
                    </a>
                    <a href="../pages/accomodations.php?room=executive">
                        <li>Executive Suite</li>
                    </a>
                    <a href="../pages/accomodations.php?room=deluxe">
                        <li>Deluxe Room</li>
                    </a>
                    <a href="../pages/accomodations.php?room=standard">
                        <li>Standard Room</li>
                    </a>
                </ul>
            </div>
        </li>
        <hr />

        <a href="../pages/facilities.php">
            <li class="nav-item-1">Facilities</li>
        </a>
        <hr />

        <a href="../pages/events.php">
            <li class="nav-item-1">Events</li>
        </a>
        <hr />
    </ul>
    <div class="h-100 align-bottom mt-5 nav-gradient"></div>
</div>

<!-- Darkening overlay on opened mobile menu -->
<div class="menu-overlay" id="menuOverlay"></div>

<!-- Scripts for components -->
<script src="../scripts/mobileNav.js"></script>