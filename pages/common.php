<!-- Favicon -->
<link rel="icon" href="../assets/favicon.ico">

<!-- Bootstrap CSS -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous" />

<!-- Bootstrap Icons -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

<!-- Flatpickr Date Picker -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

<!-- Custom Styles (must come after Bootstrap CSS) -->
<link rel="stylesheet" href="../styles/custom-alerts.css">

<!-- Put all component styles here -->

<link rel="stylesheet" href="../styles/header.css">
<link rel="stylesheet" href="../styles/booking_header.css">
<link rel="stylesheet" href="../styles/footer.css">

<!-- Bootstrap JS Bundle with Popper -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-LGj5HxVdlSvCJboEBl6Z1zWn1g9CsHLyt/TAjCOHDi9YdBIh3G2CI1VZHD0iJ3Q7"
    crossorigin="anonymous"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<?php

# utility functions to make putting components more intuitive

function placeHeader()
{
    require '../components/header.php';
}

function placeFooter()
{
    require '../components/footer.html';
}

function placeBookingHeader()
{
    require '../components/booking_header.html';
}

?>