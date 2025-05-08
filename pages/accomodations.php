<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Luxury Accommodations</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/accoms.css" />
    <?php require 'common.php'; ?>
</head>
<body>
    <?php placeHeader() ?>

    <main>
        <!-- Room Title Section -->
        <section class="room-title-section">
            <div class="container text-center">
                <h2 class="section-title" data-aos="fade-up">Our Rooms</h2>
                <div class="title-underline"></div>
                <p class="subheading-text" data-aos="fade-up">Check-in: 3:00 PM | Check-out: 12:00 PM</p>
                <p class="description-text" data-aos="fade-up">All 240+ elegantly appointed rooms offer stunning views of the sea, blending luxury and comfort to create an unforgettable stay by the shore.</p>
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
                            <p class="room-description">Step into a realm of unparalleled opulence within our Presidential Suite, where every detail whispers of exquisite design and indulgent comfort. Floor-to-ceiling windows frame a breathtaking panorama of the endless ocean, painting a living masterpiece that shifts with the sun's embrace. Sink into the embrace of plush, custom-designed furnishings in the expansive living area, a haven for relaxation and sophisticated gatherings. A gourmet kitchen, equipped with state-of-the-art appliances, stands ready for culinary creations, while an elegant dining area invites intimate meals against the backdrop of the shimmering sea. Retreat to the lavishly appointed bedrooms, each a sanctuary of tranquility with premium bedding and spa-inspired ensuite bathrooms, promising rejuvenation and serenity. Private balconies and terraces extend your living space, offering idyllic settings to savor the sea breeze, witness spectacular sunsets, and create memories that will last a lifetime in this haven of refined luxury.</p>
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
                                <div class="amenity-item"><i class="bi bi-laptop"></i> Business Center</div>
                                <div class="amenity-item"><i class="bi bi-wind"></i> Climate Control</div>
                                <div class="amenity-item"><i class="bi bi-telephone"></i> IDD Phone</div>
                            </div>
                            <div class="room-pricing">
                                <span class="price">From ₱25,000 per night</span>
                                <a class="book-btn" href="booking.php">Book Now</a>
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
                            <p class="room-description">Step into a comfortable and stylish retreat where the gentle allure of the coast enhances your stay. Generous windows offer pleasant views of the nearby shoreline, allowing natural light to fill the well-appointed space. Relax in the tastefully furnished living area, providing a comfortable setting for unwinding or catching up on work. A convenient fridge, mini - bar and coffee maker offer added convenience for light refreshments. Retreat to a serene bedroom featuring quality bedding and an ensuite bathroom with enhanced amenities. This Executive Suite provides a delightful blend of comfort and coastal ambiance, offering a step up in experience for your time in Dumaguete.</p>
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
                                <a class="book-btn" href="booking.php">Book Now</a>
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
                            <p class="room-description">Imagine entering a haven of refined comfort, where stylish design meets the soothing rhythm of the sea. Expansive windows unveil captivating vistas of the ocean, inviting the vibrant hues of sunrise and the tranquil glow of twilight into your personal sanctuary. Sink into plush, comfortable furnishings in a thoughtfully arranged living space, perfect for unwinding after a day of exploration in Dumaguete. A well-appointed ensuite bathroom offers a refreshing retreat with modern fixtures and premium amenities. Step onto your private balcony to feel the gentle sea breeze and soak in the mesmerizing coastal scenery. This Deluxe Ocean View Room provides an exceptional blend of elegance and tranquility, creating a memorable stay in the heart of the Philippines</p>
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
                                <a class="book-btn" href="booking.php">Book Now</a>
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
                            <p class="room-description">Discover a comfortable and well-appointed space designed for a restful stay. Large windows allow natural light to fill the room, creating a bright and welcoming ambiance. Enjoy the convenience of comfortable bedding, a functional workspace, and a private ensuite bathroom. This Standard Room provides all the essential amenities for a pleasant and convenient stay in Dumaguete, serving as a perfect base for your explorations or business engagements.</p>
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
                                <a class="book-btn" href="booking.php">Book Now</a>
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
