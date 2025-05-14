<?php

session_start();

require '../scripts/setup_vars.php';
require '../scripts/handle_edit.php';
require '../scripts/handle_pass.php';

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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Dockside Hotel©</title>
    <link rel="stylesheet" href="../styles/user-dashboard.css">
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
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" data-bs-toggle="dropdown">
                            Accommodations <i class="bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <span class="dropdown-header">Find your perfect stay...</span>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="#">Standard Room</a></li>
                            <li><a class="dropdown-item" href="#">Deluxe Room</a></li>
                            <li><a class="dropdown-item" href="#">Suite Room</a></li>
                            <li><a class="dropdown-item" href="#">Family Room</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
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
    <main class="container mt-4">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-2 pb-4 pb-lg-0">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#dashboard" class="nav-link active" data-tab="dashboard"
                                        onclick="ridMessage()">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#reservations" class="nav-link" data-tab="reservations"
                                        onclick="ridMessage()">
                                        <i class="bi bi-door-open-fill"></i> Manage Room Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#userbkgs" class="nav-link" data-tab="userbkgs"
                                        onclick="ridMessage()">
                                        <i class="bi bi-person"></i> User Booking History
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#roombkgs" class="nav-link" data-tab="roombkgs"
                                        onclick="ridMessage()">
                                        <i class="bi bi-gear"></i> Room Booking History
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-7">

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

                <!-- Profile Section -->
                <div class="content-section d-none" id="userbkgs-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <h2 class="card-title mt-2">My Profile</h2>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="makeEditable()">Edit Profile</button>
                            </div>

                            <hr>

                            <form id="userBookings" method="POST" action="./admin_dashboard.php#userbkgs" class="mt-4">

                                <!-- flag for conditional data handling based on what form was submitted -->
                                <input type="hidden" name="profile_submit" value="1">


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            value="<?php echo $fname; ?>" disabled required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname"
                                            value="<?php echo $lname; ?>" disabled required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="birth">Birthday</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="birth"
                                        name="birth"
                                        disabled
                                        value="<?php echo $birth; ?>"
                                        required>
                                    <small><i class="text-muted">Format: dd/mm/yyyy</i></small>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="phone"
                                        name="phone"
                                        pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}"
                                        value="<?php echo $phone; ?>"
                                        maxlength="13"
                                        disabled
                                        required />
                                    <small><i class="text-muted">Format: 0912-345-6789</i></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3" disabled><?php echo $address; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="content-section d-none" id="roombkgs-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Account Settings</h2>
                            <form id="roomBookings" method="POST" action="./admin_dashboard.php#roombkgs" class="mt-4">

                                <!-- flag for conditional data handling based on what form was submitted -->
                                <input type="hidden" name="password_submit" value="1">

                                <div class="mb-4">
                                    <h4>Change Password</h4>
                                    <br>
                                    <div class="mb-3">
                                        <div class="d-flex justify-center align-center gap-2 mb-2">
                                            <label class="form-label mb-0">Current Password</label>
                                            <button type="button" id="one" class="togshow-pword show-pword d-block" onclick="showPass('current_password', 'one', 'two')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <button type="button" id="two" class="toghide-pword hide-pword d-none" onclick="hidePass('current_password', 'one', 'two')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off">
                                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                                    <path d="m2 2 20 20" />
                                                </svg>
                                            </button>
                                        </div>
                                        <input type="password" class="form-control" id="current_password" name="current_password" value="<?php echo $pass; ?>" disabled>
                                        <br>
                                        <small><i class="text-muted">Please ensure that you input the same new password in the two fields below.</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-center align-center gap-2 mb-2">
                                            <label class="form-label" for="new_password">New Password</label>
                                            <button type="button" id="three" class="togshow-pword show-pword d-block" onclick="showPass('new_password', 'three', 'four')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <button type="button" id="four" class="toghide-pword hide-pword d-none" onclick="hidePass('new_password', 'three', 'four')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off">
                                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                                    <path d="m2 2 20 20" />
                                                </svg>
                                            </button>
                                        </div>
                                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" maxlength="30" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-center align-center gap-2 mb-2">

                                            <label class="form-label" for="confirm_password">Confirm New Password</label>
                                            <button type="button" id="five" class="togshow-pword show-pword d-block" onclick="showPass('confirm_password', 'five', 'six')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <button type="button" id="six" class="toghide-pword hide-pword d-none" onclick="hidePass('confirm_password', 'five', 'six')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off">
                                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                                    <path d="m2 2 20 20" />
                                                </svg>
                                            </button>
                                        </div>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" maxlength="30" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-key"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
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