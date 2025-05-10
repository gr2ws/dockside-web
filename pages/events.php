<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events | Dockside Hotel© </title>
    <link rel="stylesheet" href="../styles/events.css" />
    <?php require 'common.php'; ?>
</head>

<body>
    <div class="main-wrapper">
        <?php placeHeader() ?>
        <?php placeBookingHeader() ?>

        <div class="background-pattern">
            <section class="hero-section">
                <div class="hero-slider">
                    <div class="slider">
                        <div class="slide" style="background-image: url('../assets/events/jazz-night.jpg');">
                            <div class="slide-content">
                                <h1>Upcoming Events at Dockside Hotel</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../images/slider2.jpg');">
                            <div class="slide-content">
                                <h1>Experience Luxury and Entertainment</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../images/slider3.jpg');">
                            <div class="slide-content">
                                <h1>Celebrate Memorable Moments</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../images/slider4.jpg');">
                            <div class="slide-content">
                                <h1>Unforgettable Gatherings</h1>
                            </div>
                        </div>
                        <div class="slide" style="background-image: url('../images/slider5.jpg');">
                            <div class="slide-content">
                                <h1>Reserve Your Spot Today!</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <main class="events-container">
                <section class="special-events">
                    <h2><i class="bi bi-calendar-event"></i> Host Your Special Events</h2>
                    <p>Host your special events in our versatile spaces, perfect for weddings, corporate meetings, and social gatherings.</p>
                </section>

                <section class="event-list-container">
                    <button class="nav-arrow prev-arrow" aria-label="Previous events">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    
                    <div class="event-list">
                        <article class="event-card">
                            <img src="../images/event1.jpg" alt="Event 1" />
                            <div class="event-details">
                                <h2><i class="bi bi-music-note-beamed"></i> Jazz Night</h2>
                                <p>Join us for an enchanting evening of live jazz music.</p>
                                <p><strong>Date:</strong> May 15th, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event2.jpg" alt="Event 2" />
                            <div class="event-details">
                                <h2><i class="bi bi-cup"></i> Wine Tasting</h2>
                                <p>Savor the finest wines from around the world.</p>
                                <p><strong>Date:</strong> May 22nd, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event3.jpg" alt="Event 3" />
                            <div class="event-details">
                                <h2><i class="bi bi-stars"></i> Summer Gala</h2>
                                <p>Celebrate summer with an elegant evening of fine dining and entertainment.</p>
                                <p><strong>Date:</strong> June 5th, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event4.jpg" alt="Event 4" />
                            <div class="event-details">
                                <h2><i class="bi bi-moon-stars"></i> Moonlight Dinner</h2>
                                <p>An exclusive dining experience under the stars.</p>
                                <p><strong>Date:</strong> June 12th, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event5.jpg" alt="Event 5" />
                            <div class="event-details">
                                <h2><i class="bi bi-music-note"></i> Classical Concert</h2>
                                <p>Experience an evening of classical masterpieces.</p>
                                <p><strong>Date:</strong> June 19th, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event6.jpg" alt="Event 6" />
                            <div class="event-details">
                                <h2><i class="bi bi-palette"></i> Art Exhibition</h2>
                                <p>Featuring local and international artists.</p>
                                <p><strong>Date:</strong> June 25th, 2025</p>
                                <button class="book-now">Book Now</button>
                            </div>
                        </article>
                    </div>

                    <button class="nav-arrow next-arrow" aria-label="Next events">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </section>

                <section class="events-convention">
                    <h2><i class="bi bi-building"></i> Events & Convention Center</h2>
                    <p>Perfect for hosting unforgettable experiences for up to 300 guests.</p>
                    <div class="features-grid">
                        <div class="feature">
                            <i class="bi bi-people-fill"></i>
                            <h3>Capacity</h3>
                            <p>Up to 300 guests</p>
                        </div>
                        <div class="feature">
                            <i class="bi bi-camera-video-fill"></i>
                            <h3>State-of-the-Art Audiovisual Equipment</h3>
                            <p>Advanced technology to ensure your event runs smoothly.</p>
                        </div>
                        <div class="feature">
                            <i class="bi bi-egg-fried"></i>
                            <h3>Customizable Catering Options</h3>
                            <p>Delicious and tailored menus to suit every occasion.</p>
                        </div>
                        <div class="feature">
                            <i class="bi bi-person-badge-fill"></i>
                            <h3>Dedicated Event Coordinator</h3>
                            <p>Professional support to make your event seamless.</p>
                        </div>
                        <div class="feature">
                            <i class="bi bi-house"></i>
                            <h3>Versatile Spaces</h3>
                            <p>Perfect for weddings, corporate meetings, and social gatherings.</p>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <?php placeFooter() ?>
    </div>
    <script src="../scripts/events.js"></script>
</body>

</html>