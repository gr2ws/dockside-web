<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Facilities | Dockside Hotel©</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="../styles/faci.css" />
    <?php require 'common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>
    <?php placeBookingHeader() ?>
    <main id="main-content">
        <div class="body-image">
            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-content">
                    <h1>Experience Luxury by the Sea</h1>
                    <p class="hero-subtitle">Discover our world-class facilities and amenities</p>
                </div>
            </div>

            <div class="container">
                <!-- Featured Facilities -->
                <section class="featured-facilities">
                    <h2 class="section-title">Premier Facilities</h2>
                    <div class="facility-cards">
                        <article class="facility-card featured" data-facility="infinity-pool">
                            <div class="facility-image-wrapper">
                                <img src="../assets/infi-pool.jpg" alt="Infinity Pool" loading="lazy" />
                                <div class="facility-overlay">
                                    <span class="view-details-btn">View Details</span>
                                </div>
                            </div>
                            <div class="facility-content">
                                <h2>Infinity Pool</h2>
                                <p>Experience serenity in our award-winning infinity pool overlooking the ocean.</p>
                            </div>
                        </article>

                        <article class="facility-card featured" data-facility="luxury-spa">
                            <div class="facility-image-wrapper">
                                <img src="../assets/spa-card.jpg" alt="Luxury Spa" loading="lazy" />
                                <div class="facility-overlay">
                                    <span class="view-details-btn">View Details</span>
                                </div>
                            </div>
                            <div class="facility-content">
                                <h2>Luxury Spa</h2>
                                <p>Indulge in our signature treatments and holistic wellness experiences.</p>
                            </div>
                        </article>

                        <article class="facility-card featured" data-facility="elite-fitness">
                            <div class="facility-image-wrapper">
                                <img src="../assets/gym.jpg" alt="Elite Fitness Center" loading="lazy" />
                                <div class="facility-overlay">
                                    <span class="view-details-btn">View Details</span>
                                </div>
                            </div>
                            <div class="facility-content">
                                <h2>Elite Fitness</h2>
                                <p>State-of-the-art equipment and personal training in our panoramic gym.</p>
                            </div>
                        </article>
                    </div>
                </section>

                <br><hr><br>

                <!-- Amenities Showcase -->
                <section class="amenities-showcase">
                    <h2 class="section-title">Exclusive Amenities</h2>
                    <div class="amenities-grid">
                        <div class="amenity-item">
                            <div class="amenity-image">
                                <img src="../assets/resto.jpg" alt="Fine Dining" loading="lazy" />
                            </div>
                            <div class="amenity-content">
                                <h3>Fine Dining</h3>
                                <p>Elevate your stay with access to the finest tables. Explore a curated selection of Michelin-starred restaurants and bespoke dining opportunities, crafting moments of pure culinary delight. Special Dishes are also served depending on the Season!</p>
                            </div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-image">
                                <img src="../assets/priv-beach.jpg" alt="Private Beach" loading="lazy" />
                            </div>
                            <div class="amenity-content">
                                <h3>Private Beach</h3>
                                <p>Escape to our secluded private beach and unwind in luxurious premium cabanas. Enjoy dedicated butler service as you soak in the tranquility of the shoreline. Experience unparalleled seaside indulgence.</p>
                            </div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-image">
                                <img src="../assets/event-space.jpg" alt="Event Spaces" loading="lazy" />
                            </div>
                            <div class="amenity-content">
                                <h3>Event Spaces</h3>
                                <p>Host unforgettable celebrations and successful corporate gatherings in our elegant venues, designed to inspire and impress.</p>
                            </div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-image">
                                <img src="../assets/yacht.jpg" alt="Yacht Services" loading="lazy" />
                            </div>
                            <div class="amenity-content">
                                <h3>Yacht Services</h3>
                                <p>Embark on unforgettable voyages from our exclusive private marina. Discover unparalleled freedom with our luxury yacht charters, tailored to your desires for the ultimate maritime experience.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div> <!-- Close container -->

            <section class="experience-slider">
                <h2 class="section-title">Signature Experiences</h2>
                <div class="experiences-wrapper">
                    <div class="experience active" data-index="0">
                        <img src="../assets/wellness-journey.jpg" alt="Wellness Journey" loading="lazy" />
                    </div>
                    <div class="experience" data-index="1">
                        <img src="../assets/cullinary-class.jpg" alt="Culinary Masterclass" loading="lazy" />
                    </div>
                    <div class="experience" data-index="2">
                        <img src="../assets/scuba.jpg" alt="Ocean Adventures" loading="lazy" />
                    </div>
                    <button class="exp-nav-btn prev-btn" aria-label="Previous Experience">&#10094;</button>
                    <button class="exp-nav-btn next-btn" aria-label="Next Experience">&#10095;</button>
                </div>
                <div class="experience-content-wrapper">
                    <div class="experience-content active" data-index="0">
                        <h3>Wellness Journey</h3>
                        <p>Embark on a personalized wellness journey with our expert practitioners</p>
                    </div>
                    <div class="experience-content" data-index="1">
                        <h3>Cullinary Class</h3>
                        <p>Learn from world-renowned chefs in our gourmet cooking studio</p>
                    </div>
                    <div class="experience-content" data-index="2">
                        <h3>Ocean Adventures</h3>
                        <p>Discover marine life through our curated ocean experiences</p>
                    </div>
                </div>
            </section>
            
            <div class="container"> <!-- Reopen container -->
                <!-- Premium Services Section -->
                <section class="luxury-services">
                    <h2 class="section-title">Premium Services</h2>
                    <div class="services-wrapper">
                        <div class="service-column">
                            <h3>Exclusive Transportation</h3>
                            <ul>
                                <li>Private helicopter transfers</li>
                                <li>Luxury car service</li>
                                <li>Airport concierge</li>
                                <li>Yacht charters</li>
                                <li>Personal chauffeur</li>
                            </ul>
                        </div>
                        <div class="service-column">
                            <h3>Personal Assistance</h3>
                            <ul>
                                <li>24/7 room service</li>
                                <li>Personal shopping</li>
                                <li>Tour arrangements</li>
                                <li>Restaurant reservations</li>
                                <li>Event planning</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Gallery Section -->
                <section class="virtual-tour">
                    <div class="tour-content">
                        <h2>Our Facilities Gallery</h2>
                        <p>Explore our world-class facilities through our image gallery</p>
                        <button class="cta-button" id="openGallery">See Images</button>
                    </div>
                </section>
            </div>

            <!-- Gallery Lightbox -->
            <div class="lightbox-overlay" id="galleryLightbox">
                <div class="lightbox-container">
                    <span class="lightbox-close" id="closeGallery">&times;</span>
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/inf-pool.jpg" alt="Infinity Pool View" loading="lazy">
                            <div class="gallery-caption">Infinity Pool</div>
                        </div>
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/spa-room.jpg" alt="Spa Treatment Room" loading="lazy">
                            <div class="gallery-caption">Luxury Spa</div>
                        </div>
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/gym-room.jpg" alt="Modern Gym Equipment" loading="lazy">
                            <div class="gallery-caption">Elite Fitness Center</div>
                        </div>
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/gourmet-resto.jpg" alt="Fine Dining Restaurant" loading="lazy">
                            <div class="gallery-caption">Gourmet Restaurant</div>
                        </div>
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/beach-cabanas.jpg" alt="Private Beach Cabanas" loading="lazy">
                            <div class="gallery-caption">Private Beach</div>
                        </div>
                        <div class="gallery-item">
                            <img src="../assets/img-gallery/event-hall.jpg" alt="Grand Event Hall" loading="lazy">
                            <div class="gallery-caption">Event Spaces</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="facility-popup" id="facilityPopup">
        <div class="facility-popup-content">
            <span class="facility-popup-close">&times;</span>
            <div class="facility-popup-image">
                <img src="" alt="Facility Detail" id="popupImage">
            </div>
            <div class="facility-popup-details">
                <h2 id="popupTitle"></h2>
                <div class="facility-popup-description" id="popupDescription"></div>
                <div class="facility-popup-features">
                    <h3>Features & Amenities</h3>
                    <div class="features-grid" id="popupFeatures"></div>
                </div>
            </div>
        </div>
    </div>
    <?php placeFooter() ?>
    <script src="../scripts/faci.js"></script>
</body>
</html>