<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - Dockside Hotel</title>
    <link rel="stylesheet" href="../styles/aboutus.css" />


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <?php require 'common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>
    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobileSideMenu">+
        <button
            type="button"
            class="mobile-menu-close-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
            id="mobileMenuClose"
        >
            <i class="bi-x-lg"></i>
        </button>

        <p class="nav-hotel-name text-end me-2" href="#">
            Dockside Hotel
            <sup class="header-c bi-c-circle"></sup>
        </p>
        <hr />
        <ul class="navbar-nav ms-auto">
            <li class="nav-link">Home</li>
            <hr />

            <!-- TODO: refactor design -->
            <li class="nav-link">
                <span
                    data-bs-toggle="collapse"
                    href="#mobileAccommodationsCollapse"
                    aria-controls="mobileAccommodationsCollapse"
                >
                    Accommodations <i class="bi-chevron-down"></i>
                </span>
                <div class="collapse" id="mobileAccommodationsCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="nav-link" href="#">Room 1</a></li>
                        <li><a class="nav-link" href="#">Room 2</a></li>
                        <li><a class="nav-link" href="#">Room 3</a></li>
                        <li><a class="nav-link" href="#">Room 4</a></li>
                    </ul>
                </div>
            </li>
            <hr />

            <li class="nav-link">Facilities</li>
            <hr />

            <li class="nav-link">Events</li>
            <hr />
        </ul>
    </div>
    <div class="mobile-nav" id="mobileSideMenu">
			<button
				type="button"
				class="mobile-menu-close-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
				id="mobileMenuClose"
			>
				<i class="bi-x-lg"></i>
			</button>

			<p class="nav-hotel-name text-end me-2" href="#">
				Dockside Hotel
				<sup class="header-c bi-c-circle"></sup>
			</p>
			<hr />
			<ul class="navbar-nav ms-auto">
				<li class="nav-link">Home</li>
				<hr />

				<!-- TODO: refactor design -->
				<li class="nav-link">
					<span
						data-bs-toggle="collapse"
						href="#mobileAccommodationsCollapse"
						aria-controls="mobileAccommodationsCollapse"
					>
						Accommodations <i class="bi-chevron-down"></i>
					</span>
					<div class="collapse" id="mobileAccommodationsCollapse">
						<ul class="list-unstyled ps-3">
							<li><a class="nav-link" href="#">Room 1</a></li>
							<li><a class="nav-link" href="#">Room 2</a></li>
							<li><a class="nav-link" href="#">Room 3</a></li>
							<li><a class="nav-link" href="#">Room 4</a></li>
						</ul>
					</div>
				</li>
				<hr />

				<li class="nav-link">Facilities</li>
				<hr />

				<li class="nav-link">Events</li>
				<hr />
			</ul>
		</div>

    <!-- About Us Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-section bg-light py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">Welcome to Dockside Hotel</h1>
                        <p class="lead mb-4">Experience luxury and comfort at its finest in our waterfront location. Where your dream escapade comes to a reality.</p>
                        <p class="text-muted">Est. 2025</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="../assets/hotel-exterior.jpg" alt="Dockside Hotel Exterior" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

         <!-- Introduction -->
         <section class="py-5 bg-white">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mb-4">Discover Dockside Hotel</h2>
                        <p class="lead mb-4">Dockside Hotel is Dumaguete's premier waterfront luxury destination, where modern elegance meets coastal charm. Nestled along the pristine shores of the Bohol Sea, our hotel offers a perfect blend of sophisticated accommodation, world-class amenities, and authentic Filipino hospitality.</p>
                        <div class="row g-4 mt-3">
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-building fs-1 text-primary mb-3"></i>
                                    <h5>240+ Rooms</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-star fs-1 text-primary mb-3"></i>
                                    <h5>5-Star Service</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                                    <h5>Prime Location</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Story -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Our Story</h2>

        <!-- Beginning -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h4 class="mb-3">Our Beginning</h4>
                <p class="lead">Founded in 2025, Dockside Hotel has been a symbol of luxury and excellence in hospitality.</p>
                <p>Our story began nestled along the tranquil shores of Dumaguete, born from a vision to create an exceptional seaside haven. We dreamt of a place where modern comfort embraced the serene beauty of the Bohol Sea, a sanctuary meticulously crafted to offer an unforgettable experience infused with the warmth of local hospitality. From that initial spark of an idea, inspired by Dumaguete's gentle rhythm and breathtaking sunsets, we embarked on a journey to build a retreat where every detail reflects our deep connection to this coastal paradise.
                </div>
            <div class="col-md-6">
                <img src="../assets/hotel-beginning.jpg" alt="Hotel Beginning" class="img-fluid rounded shadow-sm">
            </div>
        </div>

        <!-- Mission -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 order-md-2">
                <h4 class="mb-3">Our Mission</h4>
                <p class="lead">To provide exceptional service and create memorable experiences for our guests.</p>
                <p>We are committed to delivering personalized service that exceeds expectations. Our dedicated team works tirelessly to ensure every guest feels valued and cared for, creating moments that transform ordinary stays into extraordinary memories. We believe in the power of genuine hospitality to make a difference in people's lives.</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="../assets/hotel-mission.jpg" alt="Hotel Mission" class="img-fluid rounded shadow-sm">
            </div>
        </div>

        <!-- Vision -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-3">Our Vision</h4>
                <p class="lead">To be the leading luxury hotel destination while maintaining our commitment to sustainability.</p>
                <p>Looking ahead, we envision Dockside Hotel as more than just a luxury accommodation – we aim to be a benchmark for sustainable hospitality. Our commitment extends beyond guest satisfaction to environmental stewardship and community engagement, ensuring that our success contributes to a better future for all.</p>
            </div>
            <div class="col-md-6">
                <img src="../assets/hotel-vision.jpg" alt="Hotel Vision" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Our Leadership Team</h2>
        <div class="row g-4 justify-content-center">
            <!-- Gian -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="../assets/gian.jpg" class="card-img-top" alt="Gian Ross Wennette Asunan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Gian Ross Wennette Asunan</h5>
                        <p class="card-text text-muted">C.E.O.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="text-muted me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="https://github.com/gr2ws" class="text-muted me-2"><i class="bi bi-github"></i></a>
                            <a href="mailto:gianasunan@su.edu.ph" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Lanz -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="../assets/lanz.jpg" class="card-img-top" alt="Lanz Alexander Malto">
                    <div class="card-body text-center">
                        <h5 class="card-title">Lanz Alexander Malto</h5>
                        <p class="card-text text-muted">Technical Lead</p>
                        <div class="social-links mt-3">
                            <a href="#" class="text-muted me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="https://github.com/8-MrAlex-8" class="text-muted me-2"><i class="bi bi-github"></i></a>
                            <a href="mailto:lanzimalto@su.edu.ph" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Adrian -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="../assets/adrian.jpg" class="card-img-top" alt="Adrian Philip Amihan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Adrian Philip Amihan</h5>
                        <p class="card-text text-muted">Co-Founder</p>
                        <div class="social-links mt-3">
                            <a href="https://www.linkedin.com/in/adrian-philip-v-amihan-undefined-1b1a05361/" class="text-muted me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="https://github.com/ValouteGG" class="text-muted me-2"><i class="bi bi-github"></i></a>
                            <a href="mailto:adrianamihan283@gmail.com" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php placeFooter() ?>

    <!-- Scripts -->
    <script src="scripts/mobileNav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>