<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// setting data taken from process_login.php
$id = $_SESSION['id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$birth = $_SESSION['birth'];
$pass = $_SESSION['password'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Dockside Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="../styles/user-dashboard.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>

<body>

    <?php
    //$servername = "127.0.0.1:3307";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "docksidedb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return '<div class="alert alert-danger mt-3">Database connection failed.</div>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $birth = $_POST['birth'];

        $SQLcommand =  "UPDATE person 
                            SET 
                                pers_fname = '$fname',
                                pers_lname = '$lname',
                                pers_address = '$address',
                                pers_number = '$phone',
                                pers_birthdate = '$birth'
                            WHERE pers_id = $id";

        if ($conn->query($SQLcommand) === TRUE) {
            echo    '<div class="alert alert-success d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>									
                            <div class = "ms-3">	
                                User profile edited successfully!
                            </div>
                        </div>';
        } else {
            return '<div class="alert alert-danger d-flex align-items-center mt-4 w-50" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-x me-2"><circle cx="12" cy="12" r="10"/>
                            <path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        <div>Incorrect email or password. Please try again.</div>
                    </div>';
        }
    }
    ?>

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
                    <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#dashboard" class="nav-link active" data-tab="dashboard">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#reservations" class="nav-link" data-tab="reservations">
                                        <i class="bi bi-calendar-check"></i> My Reservations
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile" class="nav-link" data-tab="profile">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" class="nav-link" data-tab="settings">
                                        <i class="bi bi-gear"></i> Settings
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-7">
                <!-- Dashboard Section -->
                <div class="content-section" id="dashboard-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Welcome Back, <?php echo $fname; ?>!</h2>
                            <p class="lead">Here's an overview of your activity and available rooms.</p>
                        </div>
                    </div>

                    <!-- Available Rooms Table -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title border-bottom pb-2">Available Rooms</h3>
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

                <!-- Reservations Section -->
                <div class="content-section d-none" id="reservations-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">My Reservations</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Room Type</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userBookings as $booking): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                                <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                <td><?php echo date('M j, Y', strtotime($booking['check_in'])); ?></td>
                                                <td><?php echo date('M j, Y', strtotime($booking['check_out'])); ?></td>
                                                <td>
                                                    <span class="badge">
                                                        <!-- <span class="badge bg-< ?php echo getStatusColor($booking['status']); ?>"> -->
                                                        <?php echo htmlspecialchars($booking['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <?php if ($booking['status'] !== 'cancelled'): ?>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="cancelBooking(<?php echo $booking['id']; ?>)">
                                                            <i class="bi bi-x-circle"></i> Cancel
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="content-section d-none" id="profile-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">My Profile</h2>
                            <form method="POST" action="./user_dashboard.php#profile" id="profileForm" class="mt-4">
                                <!-- <div class="mb-4">
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
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            value="<?php echo $fname; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            value="<?php echo $lname; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="birth">Birthday</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="birth"
                                        name="birth"
                                        required
                                        value="<?php echo $birth; ?>" required>
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
                                        required />
                                    <small><i class="text-muted">Format: 0912-345-6789</i></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?php echo $address; ?></textarea>
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
                            <form id="settingsForm" class="mt-4">
                                <div class="mb-4">
                                    <h5>Change Password</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" minlength="8">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirm_password" minlength="8">
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-key"></i> Update Password
                                    </button>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h5>Notification Preferences</h5>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="emailNotifs" name="email_notifications"
                                            <?php echo isset($userData['email_notifications']) && $userData['email_notifications'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="emailNotifs">
                                            Email Notifications
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="smsNotifs" name="sms_notifications"
                                            <?php echo isset($userData['sms_notifications']) && $userData['sms_notifications'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="smsNotifs">
                                            SMS Notifications
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="bi bi-save"></i> Save Preferences
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-md-3">
                <!-- Quick Booking Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="card-title h5 border-bottom pb-2">Quick Booking</h3>
                        <form id="quickBookingForm">
                            <div class="mb-3">
                                <label class="form-label">Check-in Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" id="checkIn" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Check-out Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" id="checkOut" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-calendar-check"></i> Book Now
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title h5 border-bottom pb-2">Recent Activity</h3>
                        <div class="recent-activity">
                            <?php if (empty($recentActivities)): ?>
                                <p class="text-muted">No recent activities</p>
                            <?php else: ?>
                                <?php foreach ($recentActivities as $activity): ?>
                                    <div class="activity-item border-bottom pb-2 mb-2">
                                        <small class="text-muted">
                                            <?php echo date('M j, Y g:i A', strtotime($activity['created_at'])); ?>
                                        </small>
                                        <p class="mb-0"><?php echo htmlspecialchars($activity['description']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../scripts/user-dashboard.js"></script>
</body>

</html>