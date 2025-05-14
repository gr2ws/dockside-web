<?php

session_start();

require '../scripts/setup_vars.php';
require '../scripts/handle_edit.php';
require '../scripts/see_history.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

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
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$birth = $_SESSION['birthday'];
$email = $_SESSION['email'];
$pass = $_SESSION['pass'];

if (isset($_POST['roomnum'])) {
    $selectedRoom = $_POST['roomnum'];
    initRoomEdit($selectedRoom);
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message']; // Retrieve the message
    unset($_SESSION['message']); // Clear the message from the session
}

$roomnum = isset($_SESSION['room_num']) ? $_SESSION['room_num'] : '';
$type = isset($_SESSION['room_type']) ? $_SESSION['room_type'] : '';
$capacity = isset($_SESSION['room_capacity']) ? $_SESSION['room_capacity'] : '';
$availability = isset($_SESSION['room_availability']) ? $_SESSION['room_availability'] : '';
$price = isset($_SESSION['room_price']) ? $_SESSION['room_price'] : '';
//$bookingid = $_SESSION['booking_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
    $message = handleRoomEdit($roomnum); // generally means successful form submission once this is triggered
    $_SESSION['message'] = $message; // Store the message in a session variable
    header("Location: ./admin_dashboard.php");
    exit(); // Redirect to the same page to avoid resubmission;
}

// Process user booking history search
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Dockside Hotel©</title>
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link rel="stylesheet" href="../styles/index.css">
    <?php require_once 'common.php'; ?>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="header-nav navbar navbar-expand-md shadow-sm">
        <div class="container">
            <button type="button" class="mobile-menu-btn d-xs-block d-sm-block d-md-none" id="mobileMenuToggle">
                <i class="bi-list"></i>
            </button>

            <a class="nav-hotel-name" href="index.html">
                Dockside Hotel
                <sup class="header-c bi-c-circle"></sup>
            </a>

            <!-- Main Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#dashboard" class="nav-link active" data-tab="dashboard"
                            onclick="ridMessage()">
                            <span class="fs-md-4"> Dashboard </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#reservations" class="nav-link" data-tab="reservations"
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

                </ul>
            </div>

            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn" type="button" data-bs-toggle="dropdown">
                    <i class="bi-person-circle"></i>
                    <span class="d-none d-lg-inline"><?php echo $fname; ?></span>
                    <i class="bi-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <span class="dropdown-header">Welcome back, <?php echo $fname; ?>!</span>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item" href="#dashboard" data-tab="dashboard">Dashboard</a>
                    <a class="dropdown-item" href="#profile" data-tab="profile">Profile</a>
                    <a class="dropdown-item" href="#settings" data-tab="settings">Settings</a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item text-danger" href="../scripts/handle_logout.php">Logout</a>
                </div>
            </div>
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
                            <h3 class="card-title border-bottom pb-2">Bookings Today</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Room Type</th>
                                            <th>Capacity</th>
                                            <th>Rate/Night</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($availableRooms as $room): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                                                <td><?php echo htmlspecialchars($room['capacity']); ?></td>
                                                <td>₱<?php echo number_format($room['rate'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $room['status'] === 'Available' ? 'success' : 'warning'; ?>">
                                                        <?php echo htmlspecialchars($room['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-primary" onclick="selectRoom(<?php echo $room['id']; ?>)">
                                                        <i class="bi bi-calendar-plus"></i> Select
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manage Room Section -->
                <div class="content-section d-none" id="reservations-content">
                    <div class=" container-fluid">

                        <!-- Manage Rooms Section -->
                        <section id="manage-rooms" class="w-100 card shadow-sm p-4">
                            <h2>Manage Rooms</h2>
                            <p>Use this section to manage room types, capacity, and availability.</p>

                            <hr>

                            <div class="border-0">
                                <form id="editrmForm" method="POST" action="./admin_dashboard.php#reservations">
                                    <div class="mb-3">
                                        <label for="roomnum" class="form-label">Room Number</label>
                                        <div class="d-flex justify-center align-center gap-3">
                                            <select class="form-select w-50" id="roomnum" name="roomnum">
                                                <option value="">Select a room:</option>
                                                <?php
                                                seeRooms()
                                                ?>
                                            </select>
                                            <button type="submit" id="check-btn" class="btn btn-success" disabled>Check</button>
                                            <button type="button" id="unlock-btn" class="btn btn-danger" disabled onclick="lockEdits()">Unlock</button>
                                        </div>
                                    </div>
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
                                        <select class="form-select" id="availability" name="availability" value="<?php echo isset($availability) ? $availability : '' ?>" disabled>
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

                                    <!-- flag for conditional data handling based on what form was submitted -->
                                    <input type="hidden" name="roomedit_submit" value="1">

                                    <button id="edit-btn" type="button" class="btn btn-primary" disabled onclick="makeEditable()">Edit Room</button>
                                    <button id="save-btn" type="submit" class="btn btn-primary" disabled>Save Room</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- User Booking History Section -->
                <div class="content-section d-none container-fluid" id="userbkgs-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">User Booking History</h2>
                            <p>Search for a user's booking history by entering their ID below.</p>

                            <form method="POST" action="./admin_dashboard.php#userbkgs" class="row g-3 align-items-end mb-4">
                                <div class="col-md-8">
                                    <label for="search_user_id" class="form-label">User ID</label>
                                    <input type="numeric" class="form-control" id="search_user_id" name="search_user_id"
                                        placeholder="Enter user ID number" required>
                                </div>
                                <div class="col-md-4">
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
                        <p> Total: <?php echo isset($userCount) ? $userCount : "-"; ?> bookings found. </p>
                    </div>
                </div>

                <!-- Room Booking History Section -->
                <div class="content-section d-none container-fluid" id="roombkgs-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Room Booking History</h2>
                            <p>Search for a room's booking history by entering the room ID below.</p>

                            <form method="POST" action="./admin_dashboard.php#roombkgs" class="row g-3 align-items-end mb-4">
                                <div class="col-md-8">
                                    <label for="search_room_id" class="form-label">Room ID</label>
                                    <input type="numeric" class="form-control" id="search_room_id" name="search_room_id"
                                        placeholder="Enter room ID number" required>
                                </div>
                                <div class="col-md-4">
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
                        <p> Total: <?php echo isset($roomCount) ? $roomCount : "-"; ?> bookings found. </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../scripts/user-dashboard.js"></script>
    <script>
        function ridMessage() {
            document.querySelector(".alert").classList.remove('d-flex');
            document.querySelector(".alert").classList.add('d-none');
        }

        function makeEditable() {
            var readItems = document.querySelectorAll('input[disabled], textarea[disabled]');
            readItems.forEach((readItem) => {
                readItem.disabled = false;
            })
        }

        function showPass(inputId, showBtnId, hideBtnId) {
            const input = document.getElementById(inputId);
            const showBtn = document.getElementById(showBtnId);
            const hideBtn = document.getElementById(hideBtnId);

            input.type = "text";
            showBtn.classList.add("d-none");
            showBtn.classList.remove("d-block");
            hideBtn.classList.remove("d-none");
            hideBtn.classList.add("d-block");
        }

        function hidePass(inputId, showBtnId, hideBtnId) {
            const input = document.getElementById(inputId);
            const showBtn = document.getElementById(showBtnId);
            const hideBtn = document.getElementById(hideBtnId);

            input.type = "password";
            hideBtn.classList.add("d-none");
            hideBtn.classList.remove("d-block");
            showBtn.classList.remove("d-none");
            showBtn.classList.add("d-block");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/admin_dbutil.js"></script>

</body>

</html>