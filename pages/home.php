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
            <div class="hero-video-container">
                <video id="hero-video" autoplay muted loop playsinline>
                    <source src="../assets/hero.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="hero-overlay"></div>
            <div class="hero-content container">
                <h1 class="hero-header">Your Perfect Getaway Awaits</h1>
                <p class="hero-blurb">Experience luxury and comfort by the waterfront. Whether you're here for a romantic escape or a family vacation, we have everything you need to make your stay unforgettable.</p>
                <a href="/pages/booking.php" class="cta-button">Book Now</a>
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