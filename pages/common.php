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

<!-- Put all component styles here -->

<?php
# Determine if in  root directory or a subdirectory
# to not make special link/scripts for index

$baseDir = '';
if (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false) {
    $baseDir = '../';
}
?>

<!-- Component styles-->

<link rel="stylesheet" href="<?php echo $baseDir; ?>styles/header.css">
<link rel="stylesheet" href="<?php echo $baseDir; ?>styles/booking_header.css">
<link rel="stylesheet" href="<?php echo $baseDir; ?>styles/footer.css">

<!-- Scripts for components -->
<script src="<?php echo $baseDir; ?>scripts/mobileNav.js"></script>


<?php

# utility functions to make putting components more intuitive

function placeHeader()
{
    require __DIR__ . '/../components/header.html';
}

function placeFooter()
{
    require __DIR__ . '/../components/footer.html';
}

function placeBookingHeader()
{
    require __DIR__ . '/../components/booking_header.html';
}

# backend functions
require '../scripts/handle_new_account.php';
require '../scripts/handle_login.php';
require '../scripts/handle_edit.php';

?>