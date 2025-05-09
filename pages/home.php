<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© </title>
    <link rel="stylesheet" href="../styles/home.css" />

    <?php require 'common.php'; ?>
</head>

<body class="home-page-body">
    <?php placeHeader() ?>
    <?php placeBookingHeader() ?>

    <div class="background-pattern">
        <div class="home-section-1 container"> <!-- Hero Section -->
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

            <!-- Accommodations Section -->
            <section class="section-container accommodations-section my-5">
                <div class="section-header text-center mb-4">
                    <h2 class="section-title">Elegant Accommodations</h2>
                    <p class="section-subtitle">Experience the perfect blend of comfort and luxury</p>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/hotel-exterior.jpg" alt="Standard Room" class="img-fluid">
                                <div class="room-badge">From ₱3,500/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Standard Room</h3>
                                <p class="room-description">Comfortable accommodations with essential amenities for a relaxing stay.</p>
                                <ul class="room-features">
                                    <li><i class="bi bi-wifi"></i> Free Wi-Fi</li>
                                    <li><i class="bi bi-tv"></i> Smart TV</li>
                                    <li><i class="bi bi-snow"></i> Air Conditioning</li>
                                </ul>
                                <a href="#" class="room-btn">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/hotel-mission.jpg" alt="Deluxe Suite" class="img-fluid">
                                <div class="room-badge">From ₱5,200/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Deluxe Suite</h3>
                                <p class="room-description">Spacious suites with premium amenities and breathtaking views.</p>
                                <ul class="room-features">
                                    <li><i class="bi bi-wifi"></i> Free Wi-Fi</li>
                                    <li><i class="bi bi-tv"></i> Smart TV</li>
                                    <li><i class="bi bi-cup-hot"></i> Coffee Maker</li>
                                </ul>
                                <a href="#" class="room-btn">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/hotel-vision.jpg" alt="Executive Suite" class="img-fluid">
                                <div class="room-badge">From ₱7,800/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Executive Suite</h3>
                                <p class="room-description">Luxury accommodations with separate living areas and premium services.</p>
                                <ul class="room-features">
                                    <li><i class="bi bi-wifi"></i> Free Wi-Fi</li>
                                    <li><i class="bi bi-tv"></i> Smart TV</li>
                                    <li><i class="bi bi-water"></i> Jacuzzi</li>
                                </ul>
                                <a href="#" class="room-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="#" class="view-all-btn">View All Accommodations <i class="bi bi-arrow-right"></i></a>
                </div>
            </section>

            <!-- Membership Benefits Section -->
            <section class="section-container membership-section my-5 py-4">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Membership Benefits</h2>
                    <p class="section-subtitle">Join our exclusive membership program and enjoy premium perks</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="benefit-card text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-star"></i>
                            </div>
                            <h3 class="benefit-title">Priority Booking</h3>
                            <p class="benefit-description">Get early access to room bookings and special events</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="benefit-card text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-percent"></i>
                            </div>
                            <h3 class="benefit-title">Exclusive Discounts</h3>
                            <p class="benefit-description">Enjoy up to 20% off on room rates and restaurant bills</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="benefit-card text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <h3 class="benefit-title">Complimentary Breakfast</h3>
                            <p class="benefit-description">Start your day with a delicious breakfast on the house</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="benefit-card text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <h3 class="benefit-title">Late Checkout</h3>
                            <p class="benefit-description">Enjoy extended checkout time at no additional cost</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="#" class="primary-btn">Become a Member</a>
                </div>
            </section>

            <!-- Facilities Section -->
            <section class="section-container facilities-section my-5">
                <div class="section-header text-center mb-4">
                    <h2 class="section-title">Hotel Facilities</h2>
                    <p class="section-subtitle">Designed for your comfort and convenience</p>
                </div>

                <div class="facilities-container">
                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-water"></i>
                        </div>
                        <h3 class="facility-title">Swimming Pool</h3>
                        <p class="facility-description">Relax and refresh in our beautiful infinity pool overlooking the ocean</p>
                    </div>

                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h3 class="facility-title">Fitness Center</h3>
                        <p class="facility-description">Stay fit during your stay with our state-of-the-art equipment</p>
                    </div>

                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-reception-4"></i>
                        </div>
                        <h3 class="facility-title">24/7 Reception</h3>
                        <p class="facility-description">Our staff is always available to assist you with any requests</p>
                    </div>

                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <h3 class="facility-title">Restaurant & Bar</h3>
                        <p class="facility-description">Enjoy delicious meals and refreshing drinks at our in-house restaurant</p>
                    </div>

                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-wifi"></i>
                        </div>
                        <h3 class="facility-title">Free Wi-Fi</h3>
                        <p class="facility-description">Stay connected with high-speed internet access throughout the property</p>
                    </div>

                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-p-circle"></i>
                        </div>
                        <h3 class="facility-title">Free Parking</h3>
                        <p class="facility-description">Complimentary parking for all hotel guests during their stay</p>
                    </div>
                </div>
            </section>

            <!-- Events/Convention Section -->
            <section class="section-container events-section my-5">
                <div class="events-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="events-image shadow-lg">
                                <img src="../assets/hotel-beginning.jpg" alt="Events and Convention Center" class="img-fluid">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="events-details">
                                <h2 class="section-title">Events & Convention Center</h2>
                                <p class="section-description">Host your special events in our versatile spaces, perfect for weddings, corporate meetings, and social gatherings.</p>

                                <div class="event-features">
                                    <div class="event-feature">
                                        <i class="bi bi-people"></i>
                                        <span>Capacity for up to 300 guests</span>
                                    </div>

                                    <div class="event-feature">
                                        <i class="bi bi-laptop"></i>
                                        <span>State-of-the-art audiovisual equipment</span>
                                    </div>

                                    <div class="event-feature">
                                        <i class="bi bi-shop"></i>
                                        <span>Customizable catering options</span>
                                    </div>

                                    <div class="event-feature">
                                        <i class="bi bi-person-lines-fill"></i>
                                        <span>Dedicated event coordinator</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="#" class="primary-btn">Inquire Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php placeFooter() ?>
</body>

</html>