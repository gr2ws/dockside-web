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
                        <p class="hero-blurb mx-auto">Experience luxury and comfort by the waterfront in Dumaguete City. Whether you're here for a romantic escape or a family vacation, we have everything you need to make your stay unforgettable.<a href="#">Learn more <i class="bi-arrow-right"></i></a></p>
                    </div>
                </div>
            </section> <!-- Accommodations Section -->
            <section class="section-container accommodations-section my-5">
                <div class="section-header text-center mb-4">
                    <h2 class="section-title">Elegant Accommodations</h2>
                    <p class="section-subtitle">Experience the perfect blend of comfort and luxury</p>
                    <p class="small text-muted mb-3">240+ Rooms | 5-Star Service | Prime Waterfront Location</p>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/standard-room.jpg" alt="Standard Room" class="img-fluid">
                                <div class="room-badge">From ₱11,000/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Standard Room</h3>
                                <p class="room-description">Discover a comfortable and well-appointed space designed for a restful stay.</p>
                                <div class="features-grid">
                                    <div class="feature-item"><i class="bi bi-house-heart"></i> 30m²</div>
                                    <div class="feature-item"><i class="bi bi-tv"></i> 40" HD TV</div>
                                    <div class="feature-item"><i class="bi bi-wifi"></i> WiFi</div>
                                    <div class="feature-item"><i class="bi bi-wind"></i> AC</div>
                                    <div class="feature-item"><i class="bi bi-telephone"></i> Phone</div>
                                    <div class="feature-item"><i class="bi bi-safe"></i> In-Room Safe</div>
                                    <div class="feature-item"><i class="bi bi-moon-stars"></i> Double Bed</div>
                                    <div class="feature-item"><i class="bi bi-door-closed"></i> City View</div>
                                </div>
                                <a href="accomodations.php#standard" class="room-link">View details <i class="bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/deluxe-room.jpg" alt="Deluxe Room" class="img-fluid">
                                <div class="room-badge">From ₱15,000/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Deluxe Room</h3>
                                <p class="room-description">Imagine entering a haven of refined comfort with captivating vistas of the ocean.</p>
                                <div class="features-grid">
                                    <div class="feature-item"><i class="bi bi-house-heart"></i> 45m²</div>
                                    <div class="feature-item"><i class="bi bi-water"></i> Ocean View</div>
                                    <div class="feature-item"><i class="bi bi-tv"></i> 43" Smart TV</div>
                                    <div class="feature-item"><i class="bi bi-wifi"></i> Fast WiFi</div>
                                    <div class="feature-item"><i class="bi bi-moon-stars"></i> Queen Bed</div>
                                    <div class="feature-item"><i class="bi bi-safe"></i> Digital Safe</div>
                                    <div class="feature-item"><i class="bi bi-cup-hot"></i> Coffee Maker</div>
                                    <div class="feature-item"><i class="bi bi-cup"></i> Mini Bar</div>
                                </div>
                                <a href="accomodations.php#deluxe" class="room-link">View details <i class="bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/executive-room.jpg" alt="Executive Suite" class="img-fluid">
                                <div class="room-badge">From ₱18,500/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Executive Suite</h3>
                                <p class="room-description">Step into a comfortable and stylish retreat with pleasant views of the shoreline.</p>
                                <div class="features-grid">
                                    <div class="feature-item"><i class="bi bi-house-heart"></i> 100m²</div>
                                    <div class="feature-item"><i class="bi bi-water"></i> Ocean View</div>
                                    <div class="feature-item"><i class="bi bi-tv"></i> 55" Smart TV</div>
                                    <div class="feature-item"><i class="bi bi-cup-hot"></i> Exec Lounge</div>
                                    <div class="feature-item"><i class="bi bi-wifi"></i> Fast WiFi</div>
                                    <div class="feature-item"><i class="bi bi-moon-stars"></i> King Bed</div>
                                    <div class="feature-item"><i class="bi bi-laptop"></i> Work Desk</div>
                                    <div class="feature-item"><i class="bi bi-cup"></i> Mini Bar</div>
                                </div>
                                <a href="accomodations.php#executive" class="room-link">View details <i class="bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="room-card shadow-sm">
                            <div class="room-image">
                                <img src="../assets/presidential-room.jpg" alt="Presidential Suite" class="img-fluid">
                                <div class="room-badge">From ₱25,000/night</div>
                            </div>
                            <div class="room-details">
                                <h3 class="room-name">Presidential Suite</h3>
                                <p class="room-description">Step into a realm of unparalleled opulence with breathtaking panorama of the ocean.</p>
                                <div class="features-grid">
                                    <div class="feature-item"><i class="bi bi-house-heart"></i> 200m²</div>
                                    <div class="feature-item"><i class="bi bi-water"></i> Infinity Pool</div>
                                    <div class="feature-item"><i class="bi bi-star-fill"></i> Ocean View</div>
                                    <div class="feature-item"><i class="bi bi-water"></i> Jacuzzi</div>
                                    <div class="feature-item"><i class="bi bi-tv"></i> 65" Smart TV</div>
                                    <div class="feature-item"><i class="bi bi-cup-hot"></i> Exec Lounge</div>
                                    <div class="feature-item"><i class="bi bi-wifi"></i> Fast WiFi</div>
                                    <div class="feature-item"><i class="bi bi-moon-stars"></i> King Bed</div>
                                </div>
                                <a href="accomodations.php#presidential" class="room-link">View details <i class="bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section> <!-- Membership Benefits Section -->
            <section class="section-container membership-section my-5">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Membership Benefits</h2>
                    <p class="section-subtitle">Join our exclusive membership program and enjoy premium perks</p>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-tags-fill"></i>
                            </div>
                            <h3 class="benefit-title">Exclusive Discounts</h3>
                            <p class="benefit-description">Enjoy up to 20% off on restaurant bills and other experiences</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-cup-hot-fill"></i>
                            </div>
                            <h3 class="benefit-title">Complimentary Breakfast</h3>
                            <p class="benefit-description">Start your day with a delicious breakfast on the house</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h3 class="benefit-title">Late Checkout</h3>
                            <p class="benefit-description">Enjoy extended checkout time at no additional cost</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="benefit-icon">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                            <h3 class="benefit-title">Online Reservation</h3>
                            <p class="benefit-description">Book your stay conveniently online anytime</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="sign_up.php" class="primary-btn">Become a Member</a>
                </div>
            </section>

            <!-- Facilities Section -->
            <section class="section-container facilities-section my-5">
                <div class="section-header text-center mb-4">
                    <h2 class="section-title">Hotel Facilities</h2>
                    <p class="section-subtitle">Designed for your comfort and convenience</p>
                    <p class="small text-muted mb-3">Nestled along the pristine shores of the Bohol Sea with breathtaking views</p>
                </div>
                <div class="facilities-container">
                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-water"></i>
                        </div>
                        <h3 class="facility-title">Swimming Pool</h3>
                        <p class="facility-description">Infinity pool overlooking the ocean with comfortable loungers and poolside service for a refreshing experience.</p>
                    </div>
                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h3 class="facility-title">Fitness Center</h3>
                        <p class="facility-description">State-of-the-art equipment and professional trainers available to help you maintain your fitness routine while traveling.</p>
                    </div>
                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-reception-4"></i>
                        </div>
                        <h3 class="facility-title">24/7 Reception</h3>
                        <p class="facility-description">Staff always available to assist with your needs, arrange transportation, and provide local recommendations anytime day or night.</p>
                    </div>
                    <div class="facility-item">
                        <div class="facility-icon">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <h3 class="facility-title">Restaurant & Bar</h3>
                        <p class="facility-description">Elegant in-house dining with international cuisine and a well-stocked bar offering both local and imported beverages for your enjoyment.</p>
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
                        <p class="facility-description">Complimentary secure parking for all hotel guests with valet service available upon request for your convenience.</p>
                    </div>
                </div>
            </section>

            <!-- Events/Convention Section -->
            <section class="section-container events-section my-5">
                <div class="events-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="events-image shadow-lg">
                                <img src="../assets/events-convention.jpg" alt="Events and Convention Center" class="img-fluid">
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
                                    <a href="events.php" class="primary-btn">Inquire Now</a>
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