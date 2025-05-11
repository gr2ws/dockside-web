<?php
session_start();
require_once '../scripts/setup_vars.php';
require_once '../scripts/handle_bookings.php';

// Check if user is logged in - more robust check to ensure valid session
$isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id']);

// Get query parameters
$checkinDate = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkoutDate = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$roomType = isset($_GET['room_type']) ? $_GET['room_type'] : '';

// Prepare redirect URL to preserve search parameters - use absolute path format
$currentUrl = "/dockside-web/pages/booking.php";
if (!empty($checkinDate) || !empty($checkoutDate) || !empty($roomType)) {
    $currentUrl .= '?';
    $params = [];

    if (!empty($checkinDate)) $params[] = 'checkin=' . urlencode($checkinDate);
    if (!empty($checkoutDate)) $params[] = 'checkout=' . urlencode($checkoutDate);
    if (!empty($roomType)) $params[] = 'room_type=' . urlencode($roomType);

    $currentUrl .= implode('&', $params);
}

// Redirect to login if user is not authenticated
if (!$isLoggedIn) {
    $_SESSION['booking_error'] = "Please log in to access the booking page.";
    header("Location: login.php?redirect=" . urlencode($currentUrl));
    exit;
}
// For any links in the page that need to redirect to login
$loginRedirect = "login.php?redirect=" . urlencode($currentUrl);

// Display any login error messages
$bookingError = '';
if (isset($_SESSION['booking_error'])) {
    $bookingError = $_SESSION['booking_error'];
    unset($_SESSION['booking_error']);
}

// Initialize booking variables
$selectedRoom = null;
$availableRooms = [];
$totalNights = 0;
$totalPrice = 0;

// Calculate nights if dates provided
if (!empty($checkinDate) && !empty($checkoutDate)) {
    $checkin = new DateTime($checkinDate);
    $checkout = new DateTime($checkoutDate);
    $totalNights = $checkout->diff($checkin)->days;
}

// Function to check room availability
function getAvailableRooms($checkin, $checkout, $roomType = '')
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        return ['error' => "Connection failed: " . $conn->connect_error];
    }

    // Base query - check for rooms that are vacant and not booked during the requested dates
    $availableRooms = [];

    if (!empty($checkin) && !empty($checkout)) {
        $checkin = $conn->real_escape_string($checkin);
        $checkout = $conn->real_escape_string($checkout);

        // Get rooms that are vacant and not already booked during this period
        $sql = "SELECT r.* FROM room r 
                WHERE r.room_avail = 'vacant'
                AND NOT EXISTS (
                    SELECT 1 FROM booking b 
                    WHERE b.room_id = r.room_id 
                    AND (
                        (b.bkg_datein <= ? AND b.bkg_dateout > ?) OR
                        (b.bkg_datein < ? AND b.bkg_dateout >= ?) OR
                        (b.bkg_datein >= ? AND b.bkg_dateout <= ?)
                    )
                )";        // Add room type filter if provided
        if (!empty($roomType)) {
            $sql .= " AND r.room_type = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $checkout, $checkin, $checkout, $checkin, $checkin, $checkout, $roomType);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $checkout, $checkin, $checkout, $checkin, $checkin, $checkout);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $availableRooms[] = $row;
            }
        }
    } else {
        // Simple room type query if no dates are provided
        $sql = "SELECT * FROM room WHERE room_avail = 'vacant'";

        // Add room type filter if provided
        if (!empty($roomType)) {
            $roomType = $conn->real_escape_string($roomType);
            $sql .= " AND room_type = '$roomType'";
        }

        // Execute query
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $availableRooms[] = $row;
            }
        }
    }

    $conn->close();
    return $availableRooms;
}

// Get available rooms if search parameters exist
if (!empty($checkinDate) && !empty($checkoutDate)) {
    $availableRooms = getAvailableRooms($checkinDate, $checkoutDate, $roomType);
} elseif (!empty($roomType)) {
    $availableRooms = getAvailableRooms(null, null, $roomType);
}

// Calculate total price if a room is selected
if (isset($_GET['selected_room'])) {
    $selectedRoomId = $_GET['selected_room'];
    foreach ($availableRooms as $room) {
        if ($room['room_id'] == $selectedRoomId) {
            $selectedRoom = $room;
            $totalPrice = $selectedRoom['room_price'] * $totalNights;
            break;
        }
    }
}

// Handle booking submission
$bookingSuccess = false;
$bookingError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    // Process the booking submission
    $roomId = $_POST['room_id'];
    $checkinDate = $_POST['checkin'];
    $checkoutDate = $_POST['checkout'];
    $userId = (int)$_SESSION['id']; // Ensure we have an integer
    $totalPrice = $_POST['total_price'];

    // Validate user ID
    if (!$userId || $userId <= 0) {
        $bookingError = "Invalid user account. Please log out and log in again.";
        $_SESSION['booking_error'] = $bookingError;
        header("Location: login.php");
        exit;
    }

    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        $bookingError = "Connection failed: " . $conn->connect_error;
    } else {
        // Begin transaction
        $conn->begin_transaction();

        try {                // Check if user ID exists in person table
            $checkUserStmt = $conn->prepare("SELECT pers_id FROM person WHERE pers_id = ?");
            $checkUserStmt->bind_param("i", $userId);
            $checkUserStmt->execute();
            $userResult = $checkUserStmt->get_result();

            if ($userResult->num_rows === 0) {
                throw new Exception("Invalid user account. Please log out and log in again.");
            }

            // Insert new booking
            $stmt = $conn->prepare("INSERT INTO booking (bkg_datein, bkg_dateout, bkg_totalpr, room_id, pers_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdii", $checkinDate, $checkoutDate, $totalPrice, $roomId, $userId);

            if ($stmt->execute()) {
                $bookingId = $conn->insert_id;

                // Update room availability
                $updateStmt = $conn->prepare("UPDATE room SET room_avail = 'occupied', booking_id = ? WHERE room_id = ?");
                $updateStmt->bind_param("ii", $bookingId, $roomId);

                if ($updateStmt->execute()) {
                    $conn->commit();
                    $bookingSuccess = true;
                } else {
                    throw new Exception("Failed to update room status");
                }
            } else {
                throw new Exception("Failed to create booking");
            }
        } catch (Exception $e) {
            $conn->rollback();
            // Get mysqli error for more details if it's a database error
            if ($conn->error) {
                $bookingError = $e->getMessage() . " - Database error: " . $conn->error;
            } else {
                $bookingError = $e->getMessage();
            }
        }

        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Book Your Stay</title>
    <?php require 'common.php'; ?>
    <link rel="stylesheet" href="../styles/booking.css" />
</head>

<body>
    <?php placeHeader() ?>

    <main class="container py-5">
        <h1 class="text-center mb-4">Book Your Stay</h1> <?php if ($bookingSuccess): ?>
            <div class="booking-success text-center">
                <div class="alert alert-success p-4" role="alert">
                    <h4 class="alert-heading"><i class="bi bi-check-circle"></i> Booking Confirmed!</h4>
                    <p>Your booking has been successfully confirmed. Thank you for choosing Dockside Hotel.</p>
                    <hr>
                    <p class="mb-0">Check your email for your booking confirmation details.</p>
                    <div class="mt-4"> <a href="home.php" class="btn btn-primary">Return to Home</a>
                        <a href="user_dashboard.php?tab=bookings" class="btn btn-outline-primary ms-2">View My Bookings</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Search Form -->
            <div class="search-section mb-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Search for Availability</h4>
                        <form action="booking.php" method="GET" id="search-form">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="search-checkin" class="form-label">Check-in Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                        <input type="text" class="form-control flatpickr-date" id="search-checkin" name="checkin" placeholder="Select date" value="<?php echo $checkinDate; ?>" data-min-date="today" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="search-checkout" class="form-label">Check-out Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                        <input type="text" class="form-control flatpickr-date" id="search-checkout" name="checkout" placeholder="Select date" value="<?php echo $checkoutDate; ?>" data-min-date="tomorrow" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="room-type" class="form-label">Room Type</label>
                                    <select class="form-select" id="room-type" name="room_type">
                                        <option value="" <?php echo empty($roomType) ? 'selected' : ''; ?>>Any Room Type</option>
                                        <option value="Presidential Suite" <?php echo $roomType == 'Presidential Suite' ? 'selected' : ''; ?>>Presidential Suite</option>
                                        <option value="Executive Suite" <?php echo $roomType == 'Executive Suite' ? 'selected' : ''; ?>>Executive Suite</option>
                                        <option value="Deluxe Room" <?php echo $roomType == 'Deluxe Room' ? 'selected' : ''; ?>>Deluxe Room</option>
                                        <option value="Standard Room" <?php echo $roomType == 'Standard Room' ? 'selected' : ''; ?>>Standard Room</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Search Availability</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php if (!empty($availableRooms) && count($availableRooms) > 0): ?>
                <!-- Room Selection Section -->
                <div class="room-selection-section mb-5">
                    <h3 class="mb-4">Available Rooms</h3>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($availableRooms as $room): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $room['room_type']; ?></h5>
                                        <p class="card-text">Room #<?php echo $room['room_id']; ?></p>
                                        <p class="card-text">Capacity: <?php echo $room['room_capacity']; ?> guests</p>
                                        <p class="card-text fw-bold">₱<?php echo number_format($room['room_price'], 2); ?> per night</p>

                                        <?php if (!empty($checkinDate) && !empty($checkoutDate)): ?>
                                            <a href="booking.php?checkin=<?php echo $checkinDate; ?>&checkout=<?php echo $checkoutDate; ?>&room_type=<?php echo urlencode($room['room_type']); ?>&selected_room=<?php echo $room['room_id']; ?>" class="btn btn-outline-primary">Select Room</a>
                                        <?php else: ?>
                                            <div class="text-warning">Please select dates to book this room</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php elseif (isset($_GET['checkin']) || isset($_GET['checkout']) || isset($_GET['room_type'])): ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> No available rooms found matching your criteria. Please try different dates or room types.
                </div>
            <?php endif; ?>

            <?php if ($selectedRoom): ?>
                <!-- Booking Summary Section -->
                <div class="booking-summary-section mb-5">
                    <h3 class="mb-4">Booking Summary</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5>Room Details</h5>
                                    <p><strong>Room Type:</strong> <?php echo $selectedRoom['room_type']; ?></p>
                                    <p><strong>Room #:</strong> <?php echo $selectedRoom['room_id']; ?></p>
                                    <p><strong>Capacity:</strong> <?php echo $selectedRoom['room_capacity']; ?> guests</p>
                                    <p><strong>Price per Night:</strong> ₱<?php echo number_format($selectedRoom['room_price'], 2); ?></p>

                                    <h5 class="mt-4">Stay Details</h5>
                                    <p><strong>Check-in Date:</strong> <?php echo date('F j, Y', strtotime($checkinDate)); ?></p>
                                    <p><strong>Check-out Date:</strong> <?php echo date('F j, Y', strtotime($checkoutDate)); ?></p>
                                    <p><strong>Duration:</strong> <?php echo $totalNights; ?> night(s)</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="card card-body bg-light">
                                        <h5>Price Summary</h5>
                                        <div class="d-flex justify-content-between mt-3">
                                            <span>Room Rate (<?php echo $totalNights; ?> nights):</span>
                                            <span>₱<?php echo number_format($selectedRoom['room_price'] * $totalNights, 2); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <span>Taxes & Fees (12%):</span>
                                            <span>₱<?php echo number_format(($selectedRoom['room_price'] * $totalNights) * 0.12, 2); ?></span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Amount:</span>
                                            <span>₱<?php echo number_format(($selectedRoom['room_price'] * $totalNights) * 1.12, 2); ?></span>
                                        </div>
                                        <form action="booking.php" method="POST" class="mt-4">
                                            <input type="hidden" name="room_id" value="<?php echo $selectedRoom['room_id']; ?>">
                                            <input type="hidden" name="checkin" value="<?php echo $checkinDate; ?>">
                                            <input type="hidden" name="checkout" value="<?php echo $checkoutDate; ?>">
                                            <input type="hidden" name="total_price" value="<?php echo ($selectedRoom['room_price'] * $totalNights) * 1.12; ?>">
                                            <button type="submit" name="confirm_booking" class="btn btn-success w-100">Confirm Booking</button>
                                            <a href="booking.php" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($bookingError)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?php echo $bookingError; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <?php placeFooter() ?> <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize checkin date picker
            const checkinPicker = flatpickr("#search-checkin", {
                minDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    // Update checkout min date when checkin changes
                    if (selectedDates.length > 0) {
                        // Set checkout min date to the day after checkin
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        checkoutPicker.set('minDate', nextDay);

                        // If checkout date is before new min, reset it
                        if (checkoutPicker.selectedDates.length > 0 &&
                            checkoutPicker.selectedDates[0] <= selectedDates[0]) {
                            checkoutPicker.setDate(nextDay);
                        }
                    }
                }
            });

            // Initialize checkout date picker
            const checkoutPicker = flatpickr("#search-checkout", {
                minDate: new Date().fp_incr(1), // tomorrow
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d"
            });

            // Validate form submission
            document.getElementById("search-form").addEventListener("submit", function(e) {
                const checkin = document.getElementById("search-checkin").value;
                const checkout = document.getElementById("search-checkout").value;

                if (!checkin || !checkout) {
                    e.preventDefault();
                    alert("Please select both check-in and check-out dates");
                    return false;
                }

                const checkinDate = new Date(checkin);
                const checkoutDate = new Date(checkout);

                if (checkinDate >= checkoutDate) {
                    e.preventDefault();
                    alert("Check-out date must be after check-in date");
                    return false;
                }

                return true;
            });
        });
    </script>
</body>

</html>