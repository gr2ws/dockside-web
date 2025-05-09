<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© </title>
    <link rel="stylesheet" href="../styles/home.css" />

    <?php require 'common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>
    <?php placeBookingHeader() ?>

    <div class="home-section-1 container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-video-container shadow-lg">
                <video id="hero-video" autoplay muted loop playsinline>
                    <source src="../assets/hero.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="hero-overlay"></div>
            <div class="hero-content d-flex align-items-center justify-content-center h-100 w-100">
                <div class="text-center">
                    <h1 class="hero-header">Your Perfect Getaway Awaits</h1>
                    <p class="hero-blurb mx-auto">Experience luxury and comfort by the waterfront. Whether you're here for a romantic escape or a family vacation, we have everything you need to make your stay unforgettable.<a href="#">Learn more <i class="bi-arrow-right"></i></a></p>
                </div>
            </div>
        </section>

        <!-- Membership benefits -->
        <!-- Accommodations -->
        <!-- Facilities -->
        <!-- Events -->
    </div>

    <?php placeFooter() ?>
</body>

</html>