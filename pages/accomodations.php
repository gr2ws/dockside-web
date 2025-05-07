<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Luxury Accommodations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="../styles/accoms.css" />
    <?php require 'common.php'; ?>
</head>
<body>
    <?php placeHeader() ?>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="fade-in">Luxury Accommodations</h1>
                        <p class="lead fade-in-delay">Experience unparalleled comfort and elegance in our carefully crafted rooms and suites. Each space is designed to provide the perfect blend of luxury, comfort, and sophisticated style.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="../assets/accom.jpg" alt="Luxury Room" class="hero-image fade-in">
                    </div>
                </div>
            </div>
        </section>

        <!-- Room Preview Cards -->
        <section class="preview-section">
            <div class="container">
                <div class="row g-4">
                    <!-- Presidential Suite Preview -->
                    <div class="col-lg-3 col-md-6">
                        <div class="preview-card" data-aos="fade-up">
                            <img src="../assets/presidential.jpg" alt="Presidential Suite">
                            <div class="preview-content">
                                <h3>Presidential Suite</h3>
                                <p>From ₱25,000/night</p>
                                <a href="#presidential" class="preview-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Executive Suite Preview -->
                    <div class="col-lg-3 col-md-6">
                        <div class="preview-card" data-aos="fade-up" data-aos-delay="100">
                            <img src="../assets/executive.jpg" alt="Executive Suite">
                            <div class="preview-content">
                                <h3>Executive Suite</h3>
                                <p>From ₱18,500/night</p>
                                <a href="#executive" class="preview-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Deluxe Room Preview -->
                    <div class="col-lg-3 col-md-6">
                        <div class="preview-card" data-aos="fade-up" data-aos-delay="200">
                            <img src="../assets/deluxe.jpg" alt="Deluxe Room">
                            <div class="preview-content">
                                <h3>Deluxe Room</h3>
                                <p>From ₱15,000/night</p>
                                <a href="#deluxe" class="preview-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Standard Room Preview -->
                    <div class="col-lg-3 col-md-6">
                        <div class="preview-card" data-aos="fade-up" data-aos-delay="300">
                            <img src="../assets/standard.jpg" alt="Standard Room">
                            <div class="preview-content">
                                <h3>Standard Room</h3>
                                <p>From ₱11,000/night</p>
                                <a href="#standard" class="preview-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities Preview -->
        <section class="facilities-section">
        <h2 class="section-title text-center">LOOK AROUND</h2>
            <div id="facilitiesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="../assets/pool.jpg" alt="Swimming Pool">
                    <div class="carousel-text">
                        <h3>SWIM.RELAX.UNWIND</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../assets/spa.jpg" alt="Spa">
                    <div class="carousel-text">
                        <h3>PAMPER.RESTORE.REJUVENATE</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../assets/resto.jpg" alt="Restaurant">
                    <div class="carousel-text">
                        <h3>DINE.SAVOR.INDULGE</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../assets/gym.jpg" alt="Gym">
                    <div class="carousel-text">
                        <h3>TRAIN.ENERGIZE.CONQUER</h3>
                    </div>
                </div>
            </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#facilitiesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#facilitiesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>

        <!-- Room Title Section -->
        <section class="room-title-section">
            <div class="container text-center py-5">
                <h2 class="section-title" data-aos="fade-up">Our Rooms</h2>
                <div class="title-underline"></div>
            </div>
        </section>

        <!-- Detailed Room Sections -->
        <!-- Presidential Suite -->
        <section id="presidential" class="room-section">
            <div class="container py-5">
                <div class="row align-items-center" data-aos="fade-right">
                    <div class="col-lg-6">
                        <div class="room-info">
                            <h2>Presidential Suite</h2>
                            <p class="room-description">Experience the epitome of luxury in our Presidential Suite with panoramic ocean views.</p>
                            <div class="amenities-grid">
                                <div class="amenity-item"><i class="bi bi-house-heart"></i> 200m²</div>
                                <div class="amenity-item"><i class="bi bi-water"></i> Infinity Pool</div>
                                <div class="amenity-item"><i class="bi bi-star-fill"></i> Ocean View</div>
                                <div class="amenity-item"><i class="bi bi-water"></i> Jacuzzi</div>
                                <div class="amenity-item"><i class="bi bi-tv"></i> 65" Smart TV</div>
                                <div class="amenity-item"><i class="bi bi-cup-hot"></i> Exec Lounge</div>
                                <div class="amenity-item"><i class="bi bi-wifi"></i> High-Speed WiFi</div>
                                <div class="amenity-item"><i class="bi bi-moon-stars"></i> King Bed</div>
                                <div class="amenity-item"><i class="bi bi-music-note-beamed"></i> Sound System</div>
                                <div class="amenity-item"><i class="bi bi-safe"></i> Digital Safe</div>
                                <div class="amenity-item"><i class="bi bi-cup"></i> Premium Bar</div>
                                <div class="amenity-item"><i class="bi bi-door-closed"></i> Private Terrace</div>
                                <div class="amenity-item"><i class="bi bi-person-check"></i> Butler Service</div>
                                <div class="amenity-item"><i class="bi bi-laptop"></i> Business Center</div>
                                <div class="amenity-item"><i class="bi bi-wind"></i> Climate Control</div>
                                <div class="amenity-item"><i class="bi bi-telephone"></i> IDD Phone</div>
                            </div>
                            <div class="room-pricing">
                                <span class="price">From ₱25,000 per night</span>
                                <button class="book-btn">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room-gallery">
                            <img src="../assets/presidential.jpg" alt="Presidential Suite">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Executive Suite -->
        <section id="executive" class="room-section bg-light">
            <div class="container py-5">
                <div class="row align-items-center" data-aos="fade-left">
                    <div class="col-lg-6">
                        <div class="room-gallery">
                            <img src="../assets/executive.jpg" alt="Executive Suite">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room-info">
                            <h2>Executive Suite</h2>
                            <p class="room-description">Perfect for business and leisure travelers seeking premium accommodation.</p>
                            <div class="amenities-grid">
                                <div class="amenity-item"><i class="bi bi-house-heart"></i> 100m²</div>
                                <div class="amenity-item"><i class="bi bi-water"></i> Ocean View</div>
                                <div class="amenity-item"><i class="bi bi-tv"></i> 55" Smart TV</div>
                                <div class="amenity-item"><i class="bi bi-cup-hot"></i> Exec Lounge</div>
                                <div class="amenity-item"><i class="bi bi-wifi"></i> High-Speed WiFi</div>
                                <div class="amenity-item"><i class="bi bi-moon-stars"></i> King Bed</div>
                                <div class="amenity-item"><i class="bi bi-laptop"></i> Work Desk</div>
                                <div class="amenity-item"><i class="bi bi-safe"></i> Digital Safe</div>
                                <div class="amenity-item"><i class="bi bi-cup"></i> Mini Bar</div>
                                <div class="amenity-item"><i class="bi bi-wind"></i> Climate Control</div>
                                <div class="amenity-item"><i class="bi bi-telephone"></i> IDD Phone</div>
                                <div class="amenity-item"><i class="bi bi-door-closed"></i> Balcony</div>
                            </div>
                            <div class="room-pricing">
                                <span class="price">From ₱18,500 per night</span>
                                <button class="book-btn">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Deluxe Room -->
        <section id="deluxe" class="room-section">
            <div class="container py-5">
                <div class="row align-items-center" data-aos="fade-right">
                    <div class="col-lg-6">
                        <div class="room-info">
                            <h2>Deluxe Room</h2>
                            <p class="room-description">Modern comfort with partial ocean views and quality amenities.</p>
                            <div class="amenities-grid">
                                <div class="amenity-item"><i class="bi bi-house-heart"></i> 45m²</div>
                                <div class="amenity-item"><i class="bi bi-water"></i> Partial Ocean View</div>
                                <div class="amenity-item"><i class="bi bi-tv"></i> 43" Smart TV</div>
                                <div class="amenity-item"><i class="bi bi-wifi"></i> High-Speed WiFi</div>
                                <div class="amenity-item"><i class="bi bi-moon-stars"></i> Queen Bed</div>
                                <div class="amenity-item"><i class="bi bi-safe"></i> Digital Safe</div>
                                <div class="amenity-item"><i class="bi bi-cup-hot"></i> Coffee Maker</div>
                                <div class="amenity-item"><i class="bi bi-wind"></i> Climate Control</div>
                                <div class="amenity-item"><i class="bi bi-telephone"></i> IDD Phone</div>
                                <div class="amenity-item"><i class="bi bi-cup"></i> Mini Bar</div>
                                <div class="amenity-item"><i class="bi bi-door-closed"></i> Balcony</div>
                            </div>

                            <div class="room-pricing">
                                <span class="price">From ₱15,000 per night</span>
                                <button class="book-btn">Book Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room-gallery">
                            <img src="../assets/deluxe.jpg" alt="Deluxe Room">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Standard Room -->
        <section id="standard" class="room-section bg-light">
            <div class="container py-5">
                <div class="row align-items-center" data-aos="fade-left">
                    <div class="col-lg-6">
                        <div class="room-gallery">
                            <img src="../assets/standard.jpg" alt="Standard Room">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room-info">
                            <h2>Standard Room</h2>
                            <p class="room-description">Comfortable accommodation with essential amenities.</p>
                            <div class="amenities-grid">
                                <div class="amenity-item"><i class="bi bi-house-heart"></i> 30m²</div>
                                <div class="amenity-item"><i class="bi bi-tv"></i> 40" HD TV</div>
                                <div class="amenity-item"><i class="bi bi-wifi"></i> WiFi</div>
                                <div class="amenity-item"><i class="bi bi-wind"></i> AC</div>
                                <div class="amenity-item"><i class="bi bi-telephone"></i> Phone</div>
                                <div class="amenity-item"><i class="bi bi-cup-hot"></i> Tea Set</div>
                                <div class="amenity-item"><i class="bi bi-safe"></i> In-Room Safe</div>
                                <div class="amenity-item"><i class="bi bi-moon-stars"></i> Double Bed</div>
                                <div class="amenity-item"><i class="bi bi-door-closed"></i> City View</div>
                            </div>
                            <div class="room-pricing">
                                <span class="price">From ₱11,000 per night</span>
                                <button class="book-btn">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php placeFooter() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../scripts/accoms.js" defer></script>
</body>
</html>