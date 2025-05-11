<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require '../scripts/handle_edit.php';
require '../scripts/handle_pass.php';
require '../scripts/handle_bookings.php';

// Show update result message only if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_submit'])) {
    $message = handleEdit($_SESSION['id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_submit'])) {
    $message = handleChangePass($_SESSION['id'], $_POST['new_password'], $_POST['confirm_password']);
}

// Get user bookings
$userBookings = getUserBookings($_SESSION['id']);


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
                    <a class="dropdown-item" href="#bookings" data-tab="bookings">My Bookings</a>
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
                                    <a href="#bookings" class="nav-link active" data-tab="bookings"
                                        onclick="ridMessage()">
                                        <i class="bi bi-calendar-check"></i> My Bookings
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
                            <h2 class="card-title border-bottom pb-2">My Bookings</h2>

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

                            <?php if (empty($userBookings)): ?>
                                <div class="text-center my-5">
                                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                    <p class="mt-3 text-muted">You don't have any bookings yet.</p>
                                    <a href="../pages/accomodations.php" class="btn btn-primary mt-2">Browse Accommodations</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>Room Type</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Total Price</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($userBookings as $booking): ?>
                                                <?php
                                                $checkinDate = new DateTime($booking['bkg_datein']);
                                                $checkoutDate = new DateTime($booking['bkg_dateout']);
                                                $canCancel = canCancelBooking($booking['bkg_datein']);
                                                ?>
                                                <tr>
                                                    <td>#<?php echo htmlspecialchars($booking['bkg_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                                    <td><?php echo $checkinDate->format('M j, Y'); ?></td>
                                                    <td><?php echo $checkoutDate->format('M j, Y'); ?></td>
                                                    <td>₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></td>
                                                    <td class="text-end"> <?php if ($canCancel): ?> <div class="dropdown">
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
                                                            <small class="text-muted">Can't cancel (within 3 days)</small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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

    <?php placeFooter() ?>

</body>

</html>