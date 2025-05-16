<?php

session_start();

require_once __DIR__ . '/../scripts/setup_vars.php';
require_once __DIR__ . '/../scripts/handle_edit.php';
require_once __DIR__ . '/../scripts/see_history.php';

// Show update result message only if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_submit'])) {
    $message = handleEdit($_SESSION['id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_submit'])) {
    $message = handleChangePass($_SESSION['id'], $_POST['new_password'], $_POST['confirm_password']);
}

// setting data for ui
$id = $_SESSION['id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message']; // Retrieve the message
    unset($_SESSION['message']); // Clear the message from the session
}

// initiate room edit form
$roomnum = isset($_SESSION['room_num']) ? $_SESSION['room_num'] : '';
$type = isset($_SESSION['room_type']) ? $_SESSION['room_type'] : '';
$capacity = isset($_SESSION['room_capacity']) ? $_SESSION['room_capacity'] : '';
$availability = isset($_SESSION['room_availability']) ? $_SESSION['room_availability'] : '';
$price = isset($_SESSION['room_price']) ? $_SESSION['room_price'] : '';
//$bookingid = $_SESSION['booking_id'];

// reads called-upon room's data and populates the form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roomcheck_submit'])) {
    $roomnum = $_POST['roomnum'];
    populateRoomEditForm($roomnum);

    $type = $_SESSION['room_type'];
    $capacity = $_SESSION['room_capacity'];
    $availability = $_SESSION['room_availability'];
    $price =  $_SESSION['room_price'];
    header("Location: ./admin_dashboard.php#rooms");
}

// Process room edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roomedit_submit'])) {
    $message = handleRoomEdit($roomnum); // generally means successful form submission once this is triggered
    $_SESSION['message'] = $message; // Store the message in a session variable

    unset($_SESSION['room_num']);
    unset($_SESSION['room_type']);
    unset($_SESSION['room_capacity']);
    unset($_SESSION['room_availability']);
    unset($_SESSION['room_price']);

    header("Location: ./admin_dashboard.php");
    exit(); // Redirect to the same page to avoid resubmission;
}

// Fetch active bookings for today
$todaysBookings = [];
$todayCount = 0;
$result = getTodaysBookings();
$todaysBookings = $result['data'];
$todayCount = $result['count'];

// Process user booking history search (works ok)
$userBookings = [];
$userSearchError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_user_submit'])) {
    $searchUserId = $_POST['search_user_id'];
    if (!empty($searchUserId)) {
        $result = getUserBookingHistory($searchUserId);

        if (isset($result['error'])) {
            $userSearchError = $result['error'];
            $userBookings = [];
            $userCount = 0;
        } else {
            $userBookings = $result['data'];
            $userCount = $result['count'];

            if ($userCount === 0) {
                $userSearchError = "No booking history found for User ID: $searchUserId";
            }
        }
    } else {
        $userSearchError = "Please enter a User ID to search.";
        $userBookings = [];
        $userCount = 0;
    }
}

// Process room booking history search 
$roomBookings = [];
$roomSearchError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_room_submit'])) {
    $searchRoomId = $_POST['search_room_id'];
    if (!empty($searchRoomId)) {
        $result = getRoomBookingHistory($searchRoomId);

        if (isset($result['error'])) {
            $roomSearchError = $result['error'];
            $roomBookings = [];
            $roomCount = 0;
        } else {
            $roomBookings = $result['data'];
            $roomCount = $result['count'];

            if ($roomCount === 0) {
                $roomSearchError = "No booking history found for Room ID: $searchRoomId";
            }
        }
    } else {
        $roomSearchError = "Please enter a Room ID to search";
        $roomBookings = [];
        $roomCount = 0;
    }
}

// initate booking edit form 
$book_id = isset($_SESSION['book_id']) ? $_SESSION['book_id'] : '';
$date_in = isset($_SESSION['bkg_datein']) ? $_SESSION['bkg_datein'] : '';
$date_out = isset($_SESSION['bkg_dateout']) ? $_SESSION['bkg_dateout'] : '';
$bkg_amount = isset($_SESSION['bkg_totalpr']) ? $_SESSION['bkg_totalpr'] : '';

// reads called-upon booking's data and populates the form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookcheck_submit'])) {
    $book_id = $_POST['book_id'];
    populateBookingEditForm($book_id);

    $book_id = $_SESSION['book_id'];
    $date_in = $_SESSION['bkg_datein'];
    $date_out = $_SESSION['bkg_dateout'];
    $bkg_amount = $_SESSION['bkg_totalpr'];

    header("Location: ./admin_dashboard.php#reservation");
    exit();
}

// Process room edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookedit_submit'])) {
    $message = handleBookingEdit($book_id); // generally means successful form submission once this is triggered
    $_SESSION['message'] = $message; // Store the message in a session variable

    unset($_SESSION['book_id']);
    unset($_SESSION['bkg_datein']);
    unset($_SESSION['bkg_dateout']);
    unset($_SESSION['bkg_totalpr']);

    header("Location: ./admin_dashboard.php");
    exit(); // Redirect to the same page to avoid resubmission;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookdelete_submit'])) {
    $message = handleBookingDelete($book_id); // generally means successful form submission once this is triggered
    $_SESSION['message'] = $message; // Store the message in a session variable

    unset($_SESSION['book_id']);
    unset($_SESSION['bkg_datein']);
    unset($_SESSION['bkg_dateout']);
    unset($_SESSION['bkg_totalpr']);

    header("Location: ./admin_dashboard.php");
    exit(); // Redirect to the same page to avoid resubmission;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dockside Hotel©</title>
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link rel="stylesheet" href="../styles/index.css">
    <?php require_once 'common.php'; ?>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="header-nav navbar navbar-expand-md shadow-sm">
        <div class="container">
            <!-- <button type="button" class="mobile-menu-btn d-xs-block d-sm-block d-md-none" id="mobileMenuToggle">
                <i class="bi-list"></i>
            </button> -->

            <a class="nav-hotel-name" href="index.html">
                Dockside Hotel
                <sup class="header-c bi-c-circle"></sup>
            </a>
            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn" type="button" data-bs-toggle="dropdown">
                    <i class="bi-person-circle"></i>
                    <span class="d-none d-lg-inline person-lk"><?php echo $fname; ?></span>
                    <i class="bi-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-danger p-3 bi bi-power" href="../scripts/handle_logout.php"> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <nav>
        <!-- Main Navigation -->
        <div class="navbar" id="navbarNav" style="background-color: #f8f8f8;">
            <ul class="navbar-nav d-flex flex-row justify-center align-items-center mx-auto">
                <li class="nav-item">
                    <a href="#dashboard" class="nav-link" data-tab="dashboard"
                        onclick="ridMessage()">
                        <span class="fs-md-4 active"> Dashboard </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#rooms" class="nav-link" data-tab="rooms"
                        onclick="ridMessage()">
                        <span class="fs-md-4"> Manage Rooms </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#userbkgs" class="nav-link" data-tab="userbkgs"
                        onclick="ridMessage()">
                        <span class="fs-md-4"> User Bookings </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#roombkgs" class="nav-link" data-tab="roombkgs"
                        onclick="ridMessage()">
                        <span class="fs-md-4"> Room Bookings </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#reservation" class="nav-link" data-tab="reservation"
                        onclick="ridMessage()">
                        <span class="fs-md-4"> Manage Reservation </span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid mt-4">
        <div class="row">
            <!-- Content Area -->
            <div class="col-9 mx-auto">

                <?php echo $message ?? ''; ?>

                <!-- Dashboard Section -->
                <div class="content-section" id="dashboard-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Welcome back, <?php echo $fname . "!"; ?></h2>
                            <p class="lead">Here's an overview of current bookings for today:</p>
                        </div>
                    </div>

                    <!-- Bookings Today Table -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title border-bottom pb-2">Active Bookings Today</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="sticky-top bg-light">
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Room ID</th>
                                            <th>Room Type</th>
                                            <th>Check-in Date</th>
                                            <th>Check-out Date</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php



                                        foreach ($todaysBookings as $booking): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['pers_id']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['room_id']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['bkg_datein']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['bkg_dateout']); ?></td>
                                                <td>₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <p> Total: <?php echo isset($todayCount) ? $todayCount : "-"; ?> booking/s found. </p>
                    </div>
                </div>

                <!-- Manage Room Section -->
                <div class=" content-section d-none" id="rooms-content">
                    <div class=" container-fluid">

                        <section id="manage-rooms" class="w-100 card shadow-sm p-4 mb-4">
                            <h2 class="card-title">Manage Rooms</h2>
                            <p>Manage room types, capacity, and availability here.</p>

                            <hr>

                            <div class="border-0">
                                <!-- manage rooms form -->
                                <form id="editrmForm" method="POST" action="./admin_dashboard.php#rooms">
                                    <div class="mb-3">
                                        <label for="roomnum" class="form-label">Room Number</label>
                                        <div class="d-flex justify-center align-center gap-3">
                                            <select class="form-select w-50" id="roomnum" name="roomnum" placeholder="Select a room:" required>
                                                <option value="">Select a room:</option>
                                                <?php
                                                seeRooms() // this is fine
                                                ?>
                                            </select>
                                            <button type="submit" id="check-btn" class="btn btn-success" name="roomcheck_submit">Check</button>
                                            <button type="button" id="unlock-btn" class="btn btn-danger" disabled onclick="lockEdits()">Unlock</button>
                                        </div>
                                    </div>
                                    <section id="form_details">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Room Type</label>
                                            <input type="text" class="form-control" id="type" name="type" placeholder="Enter room type (e.g., Deluxe, Suite)" value="<?php echo isset($type) ? $type : '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="capacity" class="form-label">Capacity</label>
                                            <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter room capacity" value="<?php echo isset($capacity) ? $capacity : '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="availability" class="form-label">Availability</label>
                                            <select class="form-select" id="availability" name="availability">
                                                <option value="" <?php echo empty($availability) ? 'selected' : ''; ?> disabled>Select availability status:</option>
                                                <option value="vacant" <?php echo (isset($availability) && $availability === 'vacant') ? 'selected' : ''; ?>>Vacant</option>
                                                <option value="occupied" <?php echo (isset($availability) && $availability === 'occupied') ? 'selected' : ''; ?>>Occupied</option>
                                                <option value="maintenance" <?php echo (isset($availability) && $availability === 'maintenance') ? 'selected' : ''; ?>>Undergoing Maintenance</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Room Price (per night)</label>
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter room price (in Php)" value="<?php echo isset($price) ? $price : '' ?>" disabled>
                                        </div>
                                    </section>

                                    <button id="edit-btn" type="button" class="btn btn-primary" disabled onclick="makeEditable()">Edit Room</button>
                                    <button id="save-btn" type="submit" class="btn btn-primary" name="roomedit_submit" disabled>Save Room</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- User Booking History Section -->
                <div class="content-section d-none container-fluid" id="userbkgs-content">
                    <div class="card shadow-sm p-2 mb-4">
                        <div class="card-body">

                            <h2 class="card-title">User Booking History</h2>
                            <p>Search for a user's booking history by entering their ID below</p>

                            <hr class="mt-4">

                            <form method="POST" action="./admin_dashboard.php#userbkgs" class="row g-3 align-items-end mb-4">
                                <div class="col-md-8">
                                    <label for="search_user_id" class="form-label">User ID</label>
                                    <input type="number" class="form-control" id="search_user_id" name="search_user_id"
                                        placeholder="Enter user ID number" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="search_user_submit" value="1" class="btn btn-primary w-100">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </form>

                            <?php if (!empty($userSearchError)): ?>
                                <div class="alert alert-warning">
                                    <?php echo $userSearchError; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($userBookings)): ?>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead class="sticky-top bg-light">
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Room ID</th>
                                                <th>Room Type</th>
                                                <th>Check-in Date</th>
                                                <th>Check-out Date</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                            foreach ($userBookings as $booking): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['pers_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['bkg_datein']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['bkg_dateout']); ?></td>
                                                    <td>₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <p> Total: <?php echo isset($userCount) ? $userCount : "-"; ?> booking/s found. </p>
                    </div>
                </div>

                <!-- Room Booking History Section -->
                <div class="content-section d-none container-fluid" id="roombkgs-content">
                    <div class="card shadow-sm p-2 mb-4">
                        <div class="card-body">
                            <h2 class="card-title">Room Booking History</h2>
                            <p>Search for a room's booking history by entering the room ID below.</p>

                            <hr class="mt-4">

                            <form method="POST" action="./admin_dashboard.php#roombkgs" class="row g-3 align-items-end mb-4">
                                <div class="col-md-8">
                                    <label for="search_room_id" class="form-label">Room ID</label>
                                    <input type="number" class="form-control" id="search_room_id" name="search_room_id"
                                        placeholder="Enter room ID number" required>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" name="search_room_submit" value="1" class="btn btn-primary w-100">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </form>

                            <?php if (!empty($roomSearchError)): ?>
                                <div class="alert alert-warning">
                                    <?php echo $roomSearchError; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($roomBookings)): ?>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead class="sticky-top bg-light">
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>Room ID</th>
                                                <th>Room Type</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Check-in Date</th>
                                                <th>Check-out Date</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($roomBookings as $booking): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['pers_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['bkg_datein']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['bkg_dateout']); ?></td>
                                                    <td>₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <p> Total: <?php echo isset($roomCount) ? $roomCount : "-"; ?> booking/s found. </p>
                    </div>
                </div>

                <!-- Manage Reservation Section -->
                <div class=" content-section d-none" id="reservation-content">
                    <div class=" container-fluid">

                        <section id="manage-rooms" class="w-100 card shadow-sm p-4 mb-4">
                            <h2 class="card-title">Manage Reservations</h2>
                            <p>Edit Client Reservations here.</p>

                            <hr>

                            <div class="border-0">
                                <!-- manage reservations form -->
                                <form id="edit-rsv-form" method="POST" action="./admin_dashboard.php#reservation">
                                    <div class="mb-3">
                                        <label for="book_id" class="form-label">Booking ID</label>
                                        <div class="d-flex justify-center align-center gap-3">
                                            <select class="form-select w-50" id="book_id" name="book_id" placeholder="Select a Booking ID:" required>
                                                <option value="">Select booking ID:</option>
                                                <?php
                                                seeBookings() // TODO
                                                ?>
                                            </select>
                                            <button type="submit" id="check-booking-btn" class="btn btn-success" name="bookcheck_submit">Check</button>
                                            <button type="button" id="unlock-booking-btn" class="btn btn-danger" disabled onclick="lockBookingEdits()">Unlock</button>
                                        </div>
                                    </div>
                                    <section id="form_details">
                                        <div class="mb-3">
                                            <label for="date_in" class="form-label">Check-In Date</label>
                                            <input type="date" class="form-control d-flex justify-content-start align-items-center gap-3" id="date_in" name="date_in" placeholder="Enter Check-In Date" value="<?php echo isset($date_in) ? $date_in : '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date_out" class="form-label">Check-Out Date</label>
                                            <input type="date" class="form-control d-flex justify-content-start align-items-center gap-3" id="date_out" name="date_out" placeholder="Enter Check-Out Date" value="<?php echo isset($date_out) ? $date_out : '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bkg_amount" class="form-label">Total Amount</label>
                                            <input type="number" class="form-control" id="bkg_amount" name="bkg_amount" placeholder="Enter total booking price (in Php)" value="<?php echo isset($bkg_amount) ? $bkg_amount : '' ?>" disabled>
                                        </div>
                                    </section>

                                    <button id="edit-booking-btn" type="button" class="btn btn-primary" disabled onclick="makeBookingEditable()">Edit Reservation</button>
                                    <button id="save-booking-btn" type="submit" class="btn btn-primary" name="bookedit_submit" disabled>Save Reservation</button>
                                    <button id="delete-booking-btn" type="submit" class="btn btn-danger" name="bookdelete_submit" disabled>Delete Reservation</button>

                                </form>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../scripts/admin_dbutil.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const type = "<?php echo $type ?? ''; ?>";
            const bkgin_date = "<?php echo $date_in ?? ''; ?>";
            if (type !== '') {
                makeEditable();
            }
            if (bkgin_date !== '') {
                makeBookingEditable();
            }
        });

        function ridMessage() {
            document.querySelector(".alert").classList.remove('d-flex');
            document.querySelector(".alert").classList.add('d-none');
        }
    </script>
</body>

</html>