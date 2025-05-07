<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Luxury Accommodations</title>
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/accommos.css" />
    <script src="../scripts/accomms.js" defer></script>

    <?php require 'pages/common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>

    <main class="accommodations-container">
        <section class="hero-section">
            <h1>Experience Luxury at Dockside Hotel</h1>
            <p class="subtitle">Choose from our carefully curated selection of premium rooms</p>
        </section>

        <div class="rooms-grid">
            <!-- Presidential Suite -->
            <div class="room-card premium">
                <h2>Presidential Suite</h2>
                <img src="./images/presidential-suite.jpg" alt="Presidential Suite" class="room-image">
                <div class="room-details">
                    <h3>Ultimate Luxury Experience</h3>
                    <ul class="amenities-list">
                        <li>180° Oceanfront View</li>
                        <li>200m² Private Space</li>
                        <li>Private Balcony with Jacuzzi</li>
                        <li>24/7 Personal Butler Service</li>
                        <li>Complimentary Champagne</li>
                        <li>Private Dining Room</li>
                        <li>Premium King-Size Bed</li>
                        <li>VIP Airport Transfer</li>
                    </ul>
                    <p class="price">From $1,200 per night</p>
                    <button class="book-now">Reserve Now</button>
                </div>
            </div>

            <!-- Executive Suite -->
            <div class="room-card deluxe">
                <h2>Executive Suite</h2>
                <img src="./images/executive-suite.jpg" alt="Executive Suite" class="room-image">
                <div class="room-details">
                    <h3>Premium Comfort</h3>
                    <ul class="amenities-list">
                        <li>Ocean View</li>
                        <li>100m² Living Space</li>
                        <li>Private Balcony</li>
                        <li>Living Room Area</li>
                        <li>Premium Queen-Size Bed</li>
                        <li>Evening Turn-down Service</li>
                        <li>Mini Bar</li>
                        <li>Work Desk</li>
                    </ul>
                    <p class="price">From $800 per night</p>
                    <button class="book-now">Reserve Now</button>
                </div>
            </div>

            <!-- Deluxe Room -->
            <div class="room-card superior">
                <h2>Deluxe Room</h2>
                <img src="./images/deluxe-room.jpg" alt="Deluxe Room" class="room-image">
                <div class="room-details">
                    <h3>Elegant Comfort</h3>
                    <ul class="amenities-list">
                        <li>Partial Ocean View</li>
                        <li>45m² Space</li>
                        <li>Queen-Size Bed</li>
                        <li>Sitting Area</li>
                        <li>Room Service</li>
                        <li>Coffee Maker</li>
                        <li>Smart TV</li>
                        <li>Free Wi-Fi</li>
                    </ul>
                    <p class="price">From $500 per night</p>
                    <button class="book-now">Reserve Now</button>
                </div>
            </div>

            <!-- Standard Room -->
            <div class="room-card standard">
                <h2>Standard Room</h2>
                <img src="./images/standard-room.jpg" alt="Standard Room" class="room-image">
                <div class="room-details">
                    <h3>Comfortable Stay</h3>
                    <ul class="amenities-list">
                        <li>City View</li>
                        <li>30m² Space</li>
                        <li>Double Bed</li>
                        <li>En-suite Bathroom</li>
                        <li>Smart TV</li>
                        <li>Free Wi-Fi</li>
                        <li>Daily Housekeeping</li>
                        <li>Air Conditioning</li>
                    </ul>
                    <p class="price">From $300 per night</p>
                    <button class="book-now">Reserve Now</button>
                </div>
            </div>
        </div>

        <section class="booking-info">
            <h2>Additional Information</h2>
            <p>All rooms include:</p>
            <ul>
                <li>Complimentary high-speed Wi-Fi</li>
                <li>24/7 room service</li>
                <li>Access to fitness center</li>
                <li>Access to swimming pool</li>
                <li>Daily housekeeping</li>
            </ul>
            <p class="contact-info">For special requests or group bookings, please contact us at <a href="tel:+1234567890">+1 (234) 567-890</a></p>
        </section>
    </main>

    <?php placeFooter() ?>
</body>

</html>