<?php
session_start();
require_once '../scripts/setup_vars.php';
require_once '../scripts/handle_bookings.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle booking cancellation
    if (isset($_POST['cancel_booking']) && isset($_POST['booking_id'])) {
        $bookingId = $_POST['booking_id'];
        $userId = $_SESSION['id'] ?? 0;

        // Verify this booking belongs to the current user
        $dbConfig = getDbConfig();
        $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

        if (!$conn->connect_error) {
            $stmt = $conn->prepare("SELECT bkg_datein FROM booking WHERE bkg_id = ? AND pers_id = ?");
            $stmt->bind_param("ii", $bookingId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $cancelResult = cancelBooking($bookingId);
                if ($cancelResult === true) {
                    $_SESSION['booking_message'] = "Your booking has been successfully cancelled.";
                    $_SESSION['booking_status'] = "success";
                } else {
                    $_SESSION['booking_message'] = "Error cancelling booking: " . $cancelResult;
                    $_SESSION['booking_status'] = "danger";
                }
            } else {
                $_SESSION['booking_message'] = "Invalid booking or permission denied.";
                $_SESSION['booking_status'] = "danger";
            }

            $conn->close();
        }

        // Redirect back to dashboard
        header("Location: user_dashboard.php?tab=bookings");
        exit;
    }

    // Handle rebooking request
    if (isset($_POST['rebook_booking']) && isset($_POST['booking_id'])) {
        $bookingId = $_POST['booking_id'];
        $userId = $_SESSION['id'] ?? 0;

        // Verify this booking belongs to the current user
        $dbConfig = getDbConfig();
        $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

        if (!$conn->connect_error) {
            $stmt = $conn->prepare("SELECT b.*, r.room_type FROM booking b 
                                  JOIN room r ON b.room_id = r.room_id 
                                  WHERE b.bkg_id = ? AND b.pers_id = ?");
            $stmt->bind_param("ii", $bookingId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $booking = $result->fetch_assoc();
                $checkinDate = $booking['bkg_datein'];                // Store booking data in session for rebooking
                $_SESSION['rebooking'] = true;
                $_SESSION['rebook_id'] = $bookingId;
                // Don't force the same room type to allow switching rooms
                $_SESSION['rebook_original_type'] = $booking['room_type'];

                // Redirect to booking page without room type to allow selection of any room type
                header("Location: booking.php");
                exit;
            } else {
                $_SESSION['booking_message'] = "Invalid booking or permission denied.";
                $_SESSION['booking_status'] = "danger";
                header("Location: user_dashboard.php?tab=bookings");
                exit;
            }

            $conn->close();
        }
    }
}

// Get booking ID from request
$bookingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!$bookingId) {
    $_SESSION['booking_message'] = "Invalid booking ID.";
    $_SESSION['booking_status'] = "danger";
    header("Location: user_dashboard.php?tab=bookings");
    exit;
}

// Get booking details
$dbConfig = getDbConfig();
$conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

if ($conn->connect_error) {
    $_SESSION['booking_message'] = "Database connection failed.";
    $_SESSION['booking_status'] = "danger";
    header("Location: user_dashboard.php?tab=bookings");
    exit;
}

$userId = $_SESSION['id'];

// Fetch booking details
$stmt = $conn->prepare("SELECT b.*, r.room_type FROM booking b 
                       JOIN room r ON b.room_id = r.room_id 
                       WHERE b.bkg_id = ? AND b.pers_id = ?");
$stmt->bind_param("ii", $bookingId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    $_SESSION['booking_message'] = "Booking not found or you do not have permission.";
    $_SESSION['booking_status'] = "danger";
    header("Location: user_dashboard.php?tab=bookings");
    exit;
}

$booking = $result->fetch_assoc();
$conn->close();

// Format dates for display
$checkinDate = new DateTime($booking['bkg_datein']);
$checkoutDate = new DateTime($booking['bkg_dateout']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Manage Booking</title>
    <link rel="stylesheet" href="../styles/booking-action.css" />
    <?php require 'common.php'; ?>
</head>

<body>
    <?php placeHeader() ?>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">
                            <?php echo $action === 'cancel' ? 'Cancel Booking' : 'Rebook Your Stay'; ?>
                        </h2>

                        <div class="booking-info p-4 bg-light rounded mb-4 border-start border-4 border-primary">
                            <h5>Current Booking Details</h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Booking ID:</strong> #<?php echo $booking['bkg_id']; ?></p>
                                    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room_type']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Check-in:</strong> <?php echo $checkinDate->format('M j, Y'); ?></p>
                                    <p><strong>Check-out:</strong> <?php echo $checkoutDate->format('M j, Y'); ?></p>
                                </div>
                            </div>
                            <p class="mt-2"><strong>Total Price:</strong> ₱<?php echo number_format($booking['bkg_totalpr'], 2); ?></p>
                        </div>

                        <?php if ($action === 'cancel'): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Warning:</strong> Cancelling your booking cannot be undone. Please confirm to proceed.
                            </div>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['bkg_id']; ?>">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="user_dashboard.php?tab=bookings" class="btn btn-secondary me-md-2">
                                        <i class="bi bi-arrow-left"></i> Go Back
                                    </a>
                                    <button type="submit" name="cancel_booking" class="btn btn-danger">
                                        <i class="bi bi-x-circle"></i> Confirm Cancellation
                                    </button>
                                </div>
                            </form>
                        <?php else: ?> <div class="alert alert-info">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <strong>Note:</strong> Rebooking will cancel your current reservation and allow you to select a new room type and new dates.
                            </div>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['bkg_id']; ?>">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="user_dashboard.php?tab=bookings" class="btn btn-secondary me-md-2">
                                        <i class="bi bi-arrow-left"></i> Go Back
                                    </a> <button type="submit" name="rebook_booking" class="btn btn-primary">
                                        <i class="bi bi-calendar"></i> Select New Room & Dates
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main> <?php placeFooter() ?>

    <script src="../scripts/booking.js"></script>
    <script>
        // Initialize booking functionality
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize form validation
            const cancelForm = document.querySelector('form[name="cancel_booking"]');
            if (cancelForm) {
                cancelForm.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            }

            const rebookForm = document.querySelector('form[name="rebook_booking"]');
            if (rebookForm) {
                rebookForm.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to rebook this reservation? You\'ll be redirected to select a new room type and new dates.')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>

</html>