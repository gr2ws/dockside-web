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
                    <p>Welcome,  Host your special events in our versatile spaces, perfect for weddings, corporate meetings, and social gatherings.</p>
                </section>

                <section class="event-list-container">
                    <button class="nav-arrow prev-arrow" aria-label="Previous events">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    
                    <div class="event-list">
                        <article class="event-card">
                            <img src="../images/event1.jpg" alt="Event 1" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-music-note-beamed"></i> Jazz Night</h2>
                                    <p>Join us for an enchanting evening of live jazz music.</p>
                                    <p class="date"><strong>Date:</strong> May 15th, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event2.jpg" alt="Event 2" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-cup"></i> Wine Tasting</h2>
                                    <p>Savor the finest wines from around the world.</p>
                                    <p class="date"><strong>Date:</strong> May 22nd, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event3.jpg" alt="Event 3" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-stars"></i> Summer Gala</h2>
                                    <p>Celebrate summer with an elegant evening of fine dining and entertainment.</p>
                                    <p class="date"><strong>Date:</strong> June 5th, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event4.jpg" alt="Event 4" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-moon-stars"></i> Moonlight Dinner</h2>
                                    <p>An exclusive dining experience under the stars.</p>
                                    <p class="date"><strong>Date:</strong> June 12th, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event5.jpg" alt="Event 5" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-music-note"></i> Classical Concert</h2>
                                    <p>Experience an evening of classical masterpieces.</p>
                                    <p class="date"><strong>Date:</strong> June 19th, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
                            </div>
                        </article>
                        <article class="event-card">
                            <img src="../images/event6.jpg" alt="Event 6" />
                            <div class="event-details">
                                <div class="content">
                                    <h2><i class="bi bi-palette"></i> Art Exhibition</h2>
                                    <p>Featuring local and international artists.</p>
                                    <p class="date"><strong>Date:</strong> June 25th, 2025</p>
                                </div>
                                <div class="actions">
                                    <button class="book-now">Book Now</button>
                                </div>
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

                <section class="upcoming-events-section">
                    <h2>Upcoming Events</h2>
                    <div class="upcoming-events-grid">
                        <div class="upcoming-event-card large" style="background-image: url('../images/upcoming-event1.jpg');">
                            <div class="overlay">
                                <h3>Jazz Night</h3>
                                <p>May 15th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event2.jpg');">
                            <div class="overlay">
                                <h3>Wine Tasting</h3>
                                <p>May 22nd, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event3.jpg');">
                            <div class="overlay">
                                <h3>Summer Gala</h3>
                                <p>June 5th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card large" style="background-image: url('../images/upcoming-event4.jpg');">
                            <div class="overlay">
                                <h3>Moonlight Dinner</h3>
                                <p>June 12th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event5.jpg');">
                            <div class="overlay">
                                <h3>Classical Concert</h3>
                                <p>June 19th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event6.jpg');">
                            <div class="overlay">
                                <h3>Art Exhibition</h3>
                                <p>June 25th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card large" style="background-image: url('../images/upcoming-event7.jpg');">
                            <div class="overlay">
                                <h3>Food Carnival</h3>
                                <p>July 5th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event8.jpg');">
                            <div class="overlay">
                                <h3>Book Fair</h3>
                                <p>July 10th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event9.jpg');">
                            <div class="overlay">
                                <h3>Stand-Up Comedy Night</h3>
                                <p>July 15th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card large" style="background-image: url('../images/upcoming-event10.jpg');">
                            <div class="overlay">
                                <h3>Summer Fashion Show</h3>
                                <p>July 20th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event11.jpg');">
                            <div class="overlay">
                                <h3>Tech Conference</h3>
                                <p>July 25th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event12.jpg');">
                            <div class="overlay">
                                <h3>Dance Workshop</h3>
                                <p>August 1st, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card large" style="background-image: url('../images/upcoming-event13.jpg');">
                            <div class="overlay">
                                <h3>Film Festival</h3>
                                <p>August 5th, 2025</p>
                            </div>
                        </div>
                        <div class="upcoming-event-card" style="background-image: url('../images/upcoming-event14.jpg');">
                            <div class="overlay">
                                <h3>Poetry Reading</h3>
                                <p>August 10th, 2025</p>
                            </div>
                        </div>
                    </div>
                </section>

    </div>
    <script src="../scripts/events.js"></script>
</body>
<?php placeFooter() ?>
</html>