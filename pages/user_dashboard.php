<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require '../scripts/handle_edit.php';
require '../scripts/handle_pass.php';
require '../scripts/handle_bookings.php';
require '../scripts/handle_userinfo.php'; // Add new user info handler

// Show update result message only if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_submit'])) {
    $message = handleEdit($_SESSION['id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_submit'])) {
    $message = handleChangePass($_SESSION['id'], $_POST['new_password'], $_POST['confirm_password']);
}

// Get user bookings
$userBookings = getUserBookings($_SESSION['id']);

// Get user booking history with fixed limit of 10 records
$bookingHistory = getUserBookingHistory($_SESSION['id']);

// Get user booking stats
$bookingStats = getUserBookingStats($_SESSION['id']);

// setting data for ui
$id = $_SESSION['id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$birth = $_SESSION['birthday'];
$email = $_SESSION['email'];
$pass = $_SESSION['pass'];
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
    <!-- Include Header -->
    <?php placeHeader(); ?><!-- Main Content -->
    <main class="container mt-4">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-2 pb-4 pb-lg-0">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#bookings" class="nav-link active" data-tab="bookings"
                                        onclick="ridMessage()">
                                        <i class="bi bi-calendar-check"></i> My Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#history" class="nav-link" data-tab="history"
                                        onclick="ridMessage()">
                                        <i class="bi bi-clock-history"></i> Booking History
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile" class="nav-link" data-tab="profile"
                                        onclick="ridMessage()">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" class="nav-link" data-tab="settings"
                                        onclick="ridMessage()">
                                        <i class="bi bi-gear"></i> Settings
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div> <!-- Content Area -->
            <div class="col-md-10">

                <?php echo $message ?? ''; ?><!-- Bookings Section -->
                <div class="content-section" id="bookings-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="card-title border-bottom pb-2">
                                    <i class="bi bi-calendar-check me-2"></i>My Bookings
                                </h2>
                                <a href="../pages/accomodations.php" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-plus-circle me-1"></i> New Booking
                                </a>
                            </div>

                            <?php if (isset($_SESSION['booking_message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['booking_status'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['booking_message']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                unset($_SESSION['booking_message']);
                                unset($_SESSION['booking_status']);
                                ?>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['account_message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['account_status'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['account_message']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                unset($_SESSION['account_message']);
                                unset($_SESSION['account_status']);
                                ?> <?php endif; ?> <?php if (empty($userBookings)): ?> <div class="text-center my-5">
                                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                    <p class="mt-3 text-muted">You don't have any current or upcoming bookings.</p>
                                </div><?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>Room Type</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Duration</th>
                                                <th>Total Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($userBookings as $booking): ?>
                                                <?php
                                                            $checkinDate = new DateTime($booking['bkg_datein']);
                                                            $checkoutDate = new DateTime($booking['bkg_dateout']);
                                                            $today = new DateTime();
                                                            $canCancel = canCancelBooking($booking['bkg_datein']);

                                                            // Calculate stay duration
                                                            $interval = $checkinDate->diff($checkoutDate);
                                                            $nights = $interval->days;

                                                            // Determine status
                                                            if ($checkinDate > $today) {
                                                                $status = "Upcoming";
                                                                $statusClass = "bg-primary";
                                                                $statusIcon = "bi-calendar-check";
                                                            } else {
                                                                $status = "Active";
                                                                $statusClass = "bg-warning";
                                                                $statusIcon = "bi-clock";
                                                            }
                                                ?>
                                                <tr>
                                                    <td class="fw-bold">#<?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                    <td><?php echo $checkinDate->format('M j, Y'); ?></td>
                                                    <td><?php echo $checkoutDate->format('M j, Y'); ?></td>
                                                    <td><?php echo $nights; ?> night<?php echo $nights > 1 ? 's' : ''; ?></td>
                                                    <td class="fw-semibold">₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                                    <td class="text-center">
                                                        <?php if ($canCancel): ?>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-gear"></i> Manage
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="booking_action.php?id=<?php echo $booking['bkg_id']; ?>&action=cancel">
                                                                            <i class="bi bi-x-circle text-danger"></i> Cancel Booking
                                                                        </a></li>
                                                                    <li><a class="dropdown-item" href="booking_action.php?id=<?php echo $booking['bkg_id']; ?>&action=rebook">
                                                                            <i class="bi bi-calendar-plus text-primary"></i> Rebook Stay
                                                                        </a></li>
                                                                </ul>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">
                                                                <i class="bi bi-lock me-1"></i>
                                                                Can't cancel (within 3 days)
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- No stats widgets for My Bookings tab, as requested -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Booking History Section -->
                <div class="content-section d-none" id="history-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="card-title border-bottom pb-2">
                                    <i class="bi bi-clock-history me-2"></i>Booking History
                                </h2>
                                <div class="d-flex align-items-center">
                                    <div class="text-muted me-3">
                                        <small>From <?php echo date('M j, Y', strtotime($bookingStats['first_booking'] ?? date('Y-m-d'))); ?></small>
                                    </div>
                                    <div class="dropdown me-2">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-filter me-1"></i> Filter
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item booking-filter active" href="#" data-filter="all">All Bookings</a></li>
                                            <li><a class="dropdown-item booking-filter" href="#" data-filter="upcoming">Upcoming</a></li>
                                            <li><a class="dropdown-item booking-filter" href="#" data-filter="active">Active</a></li>
                                            <li><a class="dropdown-item booking-filter" href="#" data-filter="completed">Completed</a></li>
                                        </ul>
                                    </div>
                                    <a href="../pages/accomodations.php" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-plus-circle me-1"></i> New Booking
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <!-- Booking History List -->
                                <div class="col-md-8">
                                    <?php if (empty($bookingHistory['bookings'])): ?>
                                        <div class="text-center py-5">
                                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                            <p class="mt-3 text-muted">No booking history found.</p>
                                            <a href="../pages/accomodations.php" class="btn btn-primary mt-2">Browse Accommodations</a>
                                        </div>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Booking ID</th>
                                                        <th>Room Type</th>
                                                        <th>Check-in</th>
                                                        <th>Check-out</th>
                                                        <th>Duration</th>
                                                        <th>Total Price</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($bookingHistory['bookings'] as $booking): ?>
                                                        <?php
                                                        $checkinDate = new DateTime($booking['bkg_datein']);
                                                        $checkoutDate = new DateTime($booking['bkg_dateout']);
                                                        $today = new DateTime();

                                                        // Calculate stay duration
                                                        $interval = $checkinDate->diff($checkoutDate);
                                                        $nights = $interval->days;

                                                        // Determine status
                                                        $status = "Upcoming";
                                                        $statusClass = "bg-primary";
                                                        $statusIcon = "bi-calendar-check";

                                                        if ($checkinDate > $today) {
                                                            $status = "Upcoming";
                                                            $statusClass = "bg-primary";
                                                            $statusIcon = "bi-calendar-check";
                                                        } elseif ($checkoutDate < $today) {
                                                            $status = "Completed";
                                                            $statusClass = "bg-success";
                                                            $statusIcon = "bi-check-circle";
                                                        } else {
                                                            $status = "Active";
                                                            $statusClass = "bg-warning";
                                                            $statusIcon = "bi-clock";
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="fw-bold">#<?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                            <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                            <td><?php echo $checkinDate->format('M j, Y'); ?></td>
                                                            <td><?php echo $checkoutDate->format('M j, Y'); ?></td>
                                                            <td><?php echo $nights; ?> night<?php echo $nights > 1 ? 's' : ''; ?></td>
                                                            <td class="fw-semibold">₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                                            <td>
                                                                <span class="badge <?php echo $statusClass; ?>">
                                                                    <i class="bi <?php echo $statusIcon; ?> me-1"></i>
                                                                    <?php echo $status; ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Booking Statistics -->
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="m-0"><i class="bi bi-bar-chart-line me-2"></i>Booking Summary</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-primary bg-opacity-10">
                                                            <i class="bi bi-calendar3 text-primary"></i>
                                                        </span>
                                                        Total Bookings
                                                    </span>
                                                    <span class="badge bg-primary rounded-pill booking-stat-value"><?php echo $bookingStats['total_bookings']; ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-success bg-opacity-10">
                                                            <i class="bi bi-calendar-check text-success"></i>
                                                        </span>
                                                        Upcoming
                                                    </span>
                                                    <span class="badge bg-success rounded-pill booking-stat-value"><?php echo $bookingStats['upcoming_bookings']; ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-info bg-opacity-10">
                                                            <i class="bi bi-calendar-x text-info"></i>
                                                        </span>
                                                        Completed
                                                    </span>
                                                    <span class="badge bg-info rounded-pill booking-stat-value"><?php echo $bookingStats['completed_bookings']; ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-warning bg-opacity-10">
                                                            <i class="bi bi-house-heart text-warning"></i>
                                                        </span>
                                                        Favorite Room
                                                    </span>
                                                    <span class="booking-stat-value"><?php echo $bookingStats['favorite_room_type']; ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-success bg-opacity-10">
                                                            <i class="bi bi-wallet2 text-success"></i>
                                                        </span>
                                                        Total Spent
                                                    </span>
                                                    <span class="booking-stat-value">₱<?php echo number_format($bookingStats['total_spent'], 2); ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <span class="booking-stat-icon bg-primary bg-opacity-10">
                                                            <i class="bi bi-moon-stars text-primary"></i>
                                                        </span>
                                                        Avg. Stay
                                                    </span>
                                                    <span class="booking-stat-value"><?php echo $bookingStats['avg_stay_duration']; ?> nights</span>
                                                </li>
                                                <?php if ($bookingStats['longest_stay'] > 0): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>
                                                            <span class="booking-stat-icon bg-danger bg-opacity-10">
                                                                <i class="bi bi-calendar-range text-danger"></i>
                                                            </span>
                                                            Longest Stay
                                                        </span>
                                                        <span class="booking-stat-value"><?php echo $bookingStats['longest_stay']; ?> nights</span>
                                                    </li> <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="content-section d-none" id="profile-content">
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

                            <form id="profileForm" method="POST" action="./user_dashboard.php" class="mt-4">

                                <!-- flag for conditional data handling based on what form was submitted -->
                                <input type="hidden" name="profile_submit" value="1">

                                <!-- (SECTION DEPRECATED)  
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="< ?php echo htmlspecialchars($userData['profile_photo'] ?? 'images/default-avatar.png'); ?>"
                                            alt="Profile" class="rounded-circle" width="80" height="80">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profilePhoto').click()">
                                            <i class="bi bi-upload"></i> Change Photo
                                        </button>
                                        <input type="file" id="profilePhoto" name="profile_photo" class="d-none" accept="image/*">
                                    </div>
                                </div> -->
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
                                        type="text"
                                        class="form-control flatpickr-date"
                                        id="birth"
                                        name="birth"
                                        placeholder="Date of birth"
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
                <div class="content-section d-none" id="settings-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Account Settings</h2>
                            <form id="settingsForm" method="POST" action="./user_dashboard.php" class="mt-4">

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
                                <!-- (SECTION DEPRECATED)
                                <hr> 
                                <div class="mb-4">
                                    <h5>Notification Preferences</h5>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="emailNotifs" name="email_notifications"
                                            < ?php echo isset($userData['email_notifications']) && $userData['email_notifications'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="emailNotifs">
                                            Email Notifications
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="smsNotifs" name="sms_notifications"
                                            < ?php echo isset($userData['sms_notifications']) && $userData['sms_notifications'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="smsNotifs">
                                            SMS Notifications
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="bi bi-save"></i> Save Preferences
                                    </button>
                                </div> -->
                            </form>

                            <hr>
                            <div class="mb-4">
                                <h4 class="text-danger">Delete Account</h4>
                                <p class="text-muted">
                                    Warning: This action cannot be undone. All your data including booking history will be permanently removed.
                                </p>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="bi bi-trash"></i> Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <p>All your personal data and booking history will be permanently removed.</p>

                    <form id="deleteAccountForm" method="POST" action="../scripts/handle_account.php">
                        <input type="hidden" name="action" value="delete_account">
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Enter your password to confirm deletion:</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['wrong_password_message'])): ?>
                                    <?php echo $_SESSION['wrong_password_message']; ?>
                                    <?php unset($_SESSION['wrong_password_message']); ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-text mt-2"><i class="bi bi-info-circle"></i> For security reasons, we need to verify your identity.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteAccountForm').submit()">Delete Account Permanently</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    <!-- Message will appear here -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script src="../scripts/user-dashboard.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if URL has a hash
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1);
                // Click the tab link
                const tabLink = document.querySelector(`a[data-tab="${tabId}"]`);
                if (tabLink) {
                    tabLink.click();
                }
            }

            // Add loading indicator for history tab
            const historyTabLink = document.querySelector('a[data-tab="history"]');
            if (historyTabLink) {
                historyTabLink.addEventListener('click', function() {
                    // Show loading indicator in the history content section
                    const historyContent = document.getElementById('history-content');

                    // Only show loading if we have data to load
                    if (historyContent && historyContent.querySelector('.table-responsive') !== null) {
                        const tableSection = historyContent.querySelector('.table-responsive');
                        tableSection.classList.add('position-relative');

                        // Create loading overlay if it doesn't exist
                        if (!tableSection.querySelector('.loading-overlay')) {
                            const loadingOverlay = document.createElement('div');
                            loadingOverlay.className = 'loading-overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75';
                            loadingOverlay.style.top = '0';
                            loadingOverlay.style.left = '0';
                            loadingOverlay.style.zIndex = '10';

                            const spinner = document.createElement('div');
                            spinner.className = 'spinner-border text-primary';
                            spinner.setAttribute('role', 'status');

                            const srText = document.createElement('span');
                            srText.className = 'visually-hidden';
                            srText.textContent = 'Loading...';

                            spinner.appendChild(srText);
                            loadingOverlay.appendChild(spinner);
                            tableSection.appendChild(loadingOverlay);

                            // Remove the loading overlay after a short delay
                            setTimeout(() => {
                                loadingOverlay.remove();
                            }, 500);
                        }
                    }
                });
            }

            // Check if we should show the delete modal (after password error)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('show_delete_modal') && urlParams.get('show_delete_modal') === '1') {
                // Wait a bit to ensure the page is loaded and error message is visible
                setTimeout(function() {
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
                    deleteModal.show();
                }, 500);
            }
        });
    </script>

    <?php placeFooter() ?>

</body>

</html>