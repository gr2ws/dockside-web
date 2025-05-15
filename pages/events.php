<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events | Dockside Hotel© </title>
    <link rel="stylesheet" href="../styles/events.css" />
    <?php require 'common.php'; ?>
</head>
    <?php placeHeader() ?>

<body>
    <div class="main-wrapper">
        <section class="background-pattern">
            <section class="hero-section">
                <div class="hero-slider">
                    <div class="slider">
                        <div class="slide" style="background-image: url('../assets/events/jazz-night.jpg');">
                            <div class="slide-content">
                                <h1>Upcoming Events at Dockside Hotel</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../assets/events/slider2.jpg');">
                            <div class="slide-content">
                                <h1>Experience Luxury and Entertainment</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../assets/events/slider3.jpg');">
                            <div class="slide-content">
                                <h1>Celebrate Memorable Moments</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../assets/events/slider4.jpg');">
                            <div class="slide-content">
                                <h1>Unforgettable Gatherings</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <!-- Special Events Section -->
            <main>
                <section class="special-events">
                    <h2 id="headingevents"></i> Host Your Special Events</h2>
                    <p>Host your special events in our versatile spaces, perfect for weddings, corporate meetings, and social gatherings.</p>
                </section>

                <section class="event-list-container">
                    <button class="nav-arrow prev-arrow" aria-label="Previous events">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    
                    <!-- Event List -->
                    <div class="event-list">
                        <article class="event-card">
                            <img src="../assets/events/jazz-night.jpg" alt="Event 1" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-music-note-beamed"></i> Jazz Night</h2>
                                    <p>Join us for an enchanting evening of live jazz music.</p>
                                    <p class="date"><strong>Date:</strong> May 15th, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../assets/events/wine-tasting.jpg" alt="Event 2" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-cup"></i> Wine Tasting</h2>
                                    <p>Savor the finest wines from around the world.</p>
                                    <p class="date"><strong>Date:</strong> May 22nd, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../assets/events/summer-gala.jpg" alt="Event 3" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-stars"></i> Summer Gala</h2>
                                    <p>Celebrate summer with an elegant evening of fine dining and entertainment.</p>
                                    <p class="date"><strong>Date:</strong> June 5th, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../assets/events/moonlit-dinner.jpg" alt="Event 4" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-moon-stars"></i> Moonlight Dinner</h2>
                                    <p>An exclusive dining experience under the stars.</p>
                                    <p class="date"><strong>Date:</strong> June 12th, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../assets/events/classical-concert.jpg" alt="Event 5" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-music-note"></i> Classical Concert</h2>
                                    <p>Experience an evening of classical masterpieces.</p>
                                    <p class="date"><strong>Date:</strong> June 19th, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../assets/events/art-exhibit.jpg" alt="Event 6" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-palette"></i> Art Exhibition</h2>
                                    <p>Featuring local and international artists.</p>
                                    <p class="date"><strong>Date:</strong> June 25th, 2025</p>
                                </div>
                                <div class="actions">
                                    <a class="book-now" href="booking.php">Book Now</a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <button class="nav-arrow next-arrow" aria-label="Next events">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </section>

                <!-- Events and Convention Center Section -->
                <section class="events-convention">
                    <div class="container-wrapper">
                        <h2><i class="bi bi-building"></i> Events & Convention Center</h2>
                        <p>Perfect for hosting unforgettable experiences for up to 300 guests.</p>
                        <div class="features-grid">
                            <div class="feature">
                                <i class="bi bi-people"></i>
                                <h3>Capacity</h3>
                                <p>Up to 300 guests</p>
                            </div>
                            <div class="feature">
                                <i class="bi bi-camera-video"></i>
                                <h3>State-of-the-Art Audiovisual Equipment</h3>
                                <p>Advanced technology to ensure your event runs smoothly.</p>
                            </div>
                            <div class="feature">
                                <i class="bi bi-egg-fried"></i>
                                <h3>Customizable Catering Options</h3>
                                <p>Delicious and tailored menus to suit every occasion.</p>
                            </div>
                            <div class="feature">
                                <i class="bi bi-person-badge"></i>
                                <h3>Dedicated Event Coordinator</h3>
                                <p>Professional support to make your event seamless.</p>
                            </div>
                            <div class="feature">
                                <i class="bi bi-house"></i>
                                <h3>Versatile Spaces</h3>
                                <p>Perfect for weddings, corporate meetings, and social gatherings.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <!-- More Upcoming Events Section -->
                <section class="upcoming-events-section">
<h2><i class="bi bi-calendar-event"></i> More Upcoming Events</h2>
                    <div class="upcoming-events-grid">
                        <div class="upcoming-event-card large" style="background-image: url('../assets/events/car-show.jpg');">
                            <div class="overlay">
                                <h3>Car Show</h3>
                                <p>July 4, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../assets/events/firework-show.jpg');">
                            <div class="overlay">
                                <h3>Firework Show</h3>
                                <p>July 12, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../assets/events/evening-gala.jpg');">
                            <div class="overlay">
                                <h3>Evening Gala</h3>
                                <p>July 25, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card large" style="background-image: url('../assets/events/pool-party.jpg');">
                            <div class="overlay">
                                <h3>Pool Party</h3>
                                <p>August 1, 2025</p>
                            </div>
                        </div>
                    </div>
                </section>
         </div>
    <script src="../scripts/events.js"></script>
</body>
<?php placeFooter() ?>
</html>