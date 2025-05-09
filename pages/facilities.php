<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© </title>
    <link rel="stylesheet" href="../styles/faci.css" />

    <?php require 'common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>
    <main class="container">

    <div class="search-container">
        <input type="text" id="facilitySearch" placeholder="Search facilities..." aria-label="Search facilities" />
    </div>

    <center><h1>Facilities</h1></center>

    <section class="facility-cards">
        <article class="facility-card" data-name="Swimming Pool">
            <img src="./images/pool.jpg" alt="Swimming Pool" />
            <h2>Swimming Pool</h2>
            <p>Relax and unwind in our luxurious swimming pool.</p>
        </article>
        <article class="facility-card" data-name="Gym">
            <img src="./images/gym.jpg" alt="Gym" />
            <h2>Gym</h2>
            <p>Stay fit and healthy with our state-of-the-art gym facilities.</p>
        </article>
        <article class="facility-card" data-name="Spa">
            <img src="./images/spa.jpg" alt="Spa" />
            <h2>Spa</h2>
            <p>Indulge in a range of rejuvenating spa treatments.</p>
        </article>
    </section>

    <section class="additional-facilities">
        <h2 class="collapsible">On-Site Facilities</h2>
        <ul class="content">
            <li><strong>Recreational:</strong> Swimming pools, fitness centers, spas, game rooms, and outdoor areas like gardens or patios.</li>
            <li><strong>Business & Events:</strong> Meeting rooms, conference facilities, business centers, and banquet halls.</li>
            <li><strong>Dining & Entertainment:</strong> Restaurants, bars, and cafes.</li>
            <li><strong>Convenience:</strong> Parking, 24-hour reception, concierge, and luggage storage.</li>
            <li><strong>Accessibility:</strong> Accessible rooms for guests with disabilities.</li>
        </ul>

        <h2 class="collapsible">Room Facilities</h2>
        <ul class="content">
            <li><strong>Comfort & Convenience:</strong> Air conditioning/heating, TV, Wi-Fi, desk, safe, mini-bar, and in-room coffee/tea making facilities.</li>
            <li><strong>Amenities:</strong> Hair dryers, toiletries, slippers, robes, and ironing facilities.</li>
            <li><strong>Technology:</strong> Smart TVs, in-room tablets, and charging ports.</li>
            <li><strong>Customization:</strong> Blackout curtains, separate dining tables, and flexible workstations.</li>
        </ul>

        <h2 class="collapsible">Additional Services</h2>
        <ul class="content">
            <li><strong>Transportation:</strong> Airport shuttles, car rentals, and local tours.</li>
        </ul>
    </section>
</main>
</body>
<script src="../scripts/faci.js"></script>
<?php placeFooter() ?>
</html>