<?php
session_start();
require_once '../scripts/setup_vars.php';
require_once '../scripts/handle_bookings.php';

// Helper function to calculate total price for auto booking
function calculateTotalPrice($checkinDate, $checkoutDate, $roomId)
{
    // Get room details first
    $room = null;
    $availableRooms = getAvailableRooms($checkinDate, $checkoutDate);

    foreach ($availableRooms as $availRoom) {
        if ($availRoom['room_id'] == $roomId) {
            $room = $availRoom;
            break;
        }
    }

    if (!$room) {
        return 0; // Room not available
    }

    // Calculate booking details
    $bookingDetails = calculateBookingDetails($checkinDate, $checkoutDate, $room);

    // Calculate additional fees (copied from the display logic)
    $baseAmount = $bookingDetails['totalPrice'];
    $serviceCharge = $baseAmount * 0.10;
    $tourismFee = $bookingDetails['totalNights'] * 150;
    $roomTax = $baseAmount * 0.12;
    $environmentalFee = $bookingDetails['totalNights'] * 100;

    // Calculate total with all fees
    $totalWithFees = $baseAmount + $serviceCharge + $tourismFee + $roomTax + $environmentalFee;

    return $totalWithFees;
}

// Get query parameters  [TO REMOVE] - will be replaced with session-based approach
$checkinDate = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkoutDate = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$roomType = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$selectedRoomParam = isset($_GET['selected_room']) ? $_GET['selected_room'] : '';
$confirmIntent = isset($_GET['confirm_intent']) ? $_GET['confirm_intent'] : '';

// Check if user has logged in or signed up with pending booking details in session
if (isset($_SESSION['id']) && isset($_SESSION['pending_booking_details']) && !isset($_POST['confirm_booking'])) {
    // User has logged in/signed up and has pending booking details
    // Auto-submit the form with the pending booking details
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST['confirm_booking'] = true;
    $_POST['room_id'] = $_SESSION['pending_booking_details']['room_id'];
    $_POST['checkin'] = $_SESSION['pending_booking_details']['checkin_date'];
    $_POST['checkout'] = $_SESSION['pending_booking_details']['checkout_date'];
    $_POST['total_price'] = $_SESSION['pending_booking_details']['total_price'];

    // Set flag to not show auth modal since user is authenticated
    $_SESSION['from_booking_flow'] = true;

    // Don't clear the session variables yet - wait until booking is successfully processed
}

// [TO REMOVE] - Old URL parameter logic
if ($confirmIntent == '1' && $selectedRoomParam && isset($_SESSION['id'])) {
    // We'll auto-process the booking in the processing section below
    // This flag helps us know this request came directly after login
    $_SESSION['just_logged_in_for_booking'] = true;
}

// [REMOVED] - Old URL parameter handling

// [REMOVED] - Login redirect with URL parameters

// Only check authentication when submitting the form or selecting a room
// Don't check during search as we want users to be able to search first
$needAuth = false;
if (isset($_POST['check_auth'])) {
    $isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id']);
    if (!$isLoggedIn) {
        $needAuth = true;
        $_SESSION['booking_error'] = "You must be logged in to book a room online.";

        // Store comprehensive booking details in session for later processing
        $_SESSION['pending_booking_details'] = [
            'room_id' => isset($_POST['room_id']) ? $_POST['room_id'] : null,
            'checkin_date' => isset($_POST['checkin']) ? $_POST['checkin'] : null,
            'checkout_date' => isset($_POST['checkout']) ? $_POST['checkout'] : null,
            'total_price' => isset($_POST['total_price']) ? $_POST['total_price'] : null,
            'timestamp' => time(), // Add timestamp for potential expiration handling
            'requires_auth' => true // Flag indicating this booking needs authentication
        ];
    }
}

// Legacy code - to be removed after full migration to new system
if (isset($_SESSION['id']) && isset($_SESSION['pending_booking']) && !isset($_POST['confirm_booking'])) {
    // Auto-submit the form with the pending booking details
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST['confirm_booking'] = true;
    $_POST['room_id'] = $_SESSION['pending_booking']['room_id'];
    $_POST['checkin'] = $_SESSION['pending_booking']['checkin'];
    $_POST['checkout'] = $_SESSION['pending_booking']['checkout'];
    $_POST['total_price'] = $_SESSION['pending_booking']['total_price'];

    // Clear the pending booking
    unset($_SESSION['pending_booking']);
}

// Display any login error messages
$bookingError = '';
if (isset($_SESSION['booking_error'])) {
    $bookingError = $_SESSION['booking_error'];
    unset($_SESSION['booking_error']);
}

// Initialize booking variables
$selectedRoom = null;
$availableRooms = [];
$bookingDetails = [
    'totalNights' => 0,
    'totalPrice' => 0,
    'checkinFormatted' => '',
    'checkoutFormatted' => ''
];

// Initialize default dates if only room type is provided
if (!empty($roomType) && (empty($checkinDate) || empty($checkoutDate))) {
    // Set default check-in to today
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    // Use these as default dates and update URL parameters to match
    $checkinDate = $today;
    $checkoutDate = $tomorrow;

    // If we're not already redirecting, update the URL to include these default dates
    if (!headers_sent()) {
        $redirectUrl = "booking.php?room_type=" . urlencode($roomType) .
            "&checkin=" . urlencode($checkinDate) .
            "&checkout=" . urlencode($checkoutDate);
        header("Location: " . $redirectUrl);
        exit();
    }
}

// Get available rooms if search parameters exist
if (!empty($checkinDate) && !empty($checkoutDate)) {
    $availableRooms = getAvailableRooms($checkinDate, $checkoutDate, $roomType);
} elseif (!empty($roomType)) {
    // This case should rarely happen now due to the auto-setting of dates above
    $availableRooms = getAvailableRooms(null, null, $roomType);
}

// Calculate total price if a room is selected
if (isset($_GET['selected_room'])) {
    $selectedRoomId = $_GET['selected_room'];
    foreach ($availableRooms as $room) {
        if ($room['room_id'] == $selectedRoomId) {
            $selectedRoom = $room;
            $bookingDetails = calculateBookingDetails($checkinDate, $checkoutDate, $selectedRoom);
            break;
        }
    }
}

// Handle booking submission
$bookingSuccess = false;
$isRebooking = isset($_SESSION['rebooking']) && $_SESSION['rebooking'] === true;
$rebookingMessage = '';

// Process booking if user has just logged in or signed up with pending booking details
if (isset($_SESSION['id']) && isset($_SESSION['from_booking_flow']) && isset($_SESSION['pending_booking_details']) && !isset($_POST['confirm_booking'])) {
    // User has authenticated from booking flow, automatically process the booking
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST['confirm_booking'] = true;
    $_POST['room_id'] = $_SESSION['pending_booking_details']['room_id'];
    $_POST['checkin'] = $_SESSION['pending_booking_details']['checkin_date'];
    $_POST['checkout'] = $_SESSION['pending_booking_details']['checkout_date'];
    $_POST['total_price'] = $_SESSION['pending_booking_details']['total_price'];

    // No need to check authentication again
    unset($_SESSION['from_booking_flow']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    // First check if user is logged in (if checking auth)
    if (isset($_POST['check_auth'])) {
        $isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id']);
        if (!$isLoggedIn) {
            // Just set a flag so we'll render the modal
            $needAuth = true;
            $_SESSION['booking_error'] = "You must be logged in to book a room online.";

            // Store comprehensive booking details in session for later processing
            $_SESSION['pending_booking_details'] = [
                'room_id' => isset($_POST['room_id']) ? $_POST['room_id'] : null,
                'checkin_date' => isset($_POST['checkin']) ? $_POST['checkin'] : null,
                'checkout_date' => isset($_POST['checkout']) ? $_POST['checkout'] : null,
                'total_price' => isset($_POST['total_price']) ? $_POST['total_price'] : null,
                'timestamp' => time(), // Add timestamp for potential expiration handling
                'requires_auth' => true // Flag indicating this booking needs authentication
            ];

            // Legacy - to be removed
            $_SESSION['pending_booking'] = [
                'room_id' => isset($_POST['room_id']) ? $_POST['room_id'] : null,
                'checkin' => isset($_POST['checkin']) ? $_POST['checkin'] : null,
                'checkout' => isset($_POST['checkout']) ? $_POST['checkout'] : null,
                'total_price' => isset($_POST['total_price']) ? $_POST['total_price'] : null
            ];

            // Don't process the rest of the booking submission
        } else {
            // User is logged in, proceed with booking
            $roomId = $_POST['room_id'];
            $checkinDate = $_POST['checkin'];
            $checkoutDate = $_POST['checkout'];
            $userId = (int)$_SESSION['id']; // Ensure we have an integer
            $totalPrice = $_POST['total_price'];

            // If this is a rebooking, cancel the old booking first
            if ($isRebooking && isset($_SESSION['rebook_id'])) {
                $oldBookingId = $_SESSION['rebook_id'];
                $cancelResult = cancelBooking($oldBookingId);

                if ($cancelResult !== true) {
                    $bookingError = "Failed to cancel the previous booking. Error: " . $cancelResult;
                } else {
                    $rebookingMessage = "Your previous booking has been cancelled. ";

                    // Proceed with new booking
                    $result = processBooking($roomId, $checkinDate, $checkoutDate, $userId, $totalPrice);
                    $bookingSuccess = $result['success'];

                    if ($bookingSuccess) {
                        $rebookingMessage .= "Your stay has been successfully rebooked.";

                        // Clear any pending booking details if exists
                        if (isset($_SESSION['pending_booking_details'])) {
                            unset($_SESSION['pending_booking_details']);
                        }
                    } else {
                        $bookingError = $result['error'];
                    }
                    // Clear rebooking session variables
                    unset($_SESSION['rebooking']);
                    unset($_SESSION['rebook_id']);
                    unset($_SESSION['rebook_original_type']);
                }
            } else {
                // Regular booking process
                $result = processBooking($roomId, $checkinDate, $checkoutDate, $userId, $totalPrice);
                $bookingSuccess = $result['success'];
                $bookingError = $result['error'];

                // Clear pending booking details if successful
                if ($bookingSuccess && isset($_SESSION['pending_booking_details'])) {
                    unset($_SESSION['pending_booking_details']);
                }
            }
        }
    } else {
        // No auth check requested, assume the user is already logged in
        $roomId = $_POST['room_id'];
        $checkinDate = $_POST['checkin'];
        $checkoutDate = $_POST['checkout'];
        $userId = (int)$_SESSION['id']; // Ensure we have an integer
        $totalPrice = $_POST['total_price'];

        // Process the booking normally
        if ($isRebooking && isset($_SESSION['rebook_id'])) {
            $oldBookingId = $_SESSION['rebook_id'];
            $cancelResult = cancelBooking($oldBookingId);

            if ($cancelResult !== true) {
                $bookingError = "Failed to cancel the previous booking. Error: " . $cancelResult;
            } else {
                $rebookingMessage = "Your previous booking has been cancelled. ";

                // Proceed with new booking
                $result = processBooking($roomId, $checkinDate, $checkoutDate, $userId, $totalPrice);
                $bookingSuccess = $result['success'];

                if ($bookingSuccess) {
                    $rebookingMessage .= "Your stay has been successfully rebooked.";
                } else {
                    $bookingError = $result['error'];
                }
                // Clear rebooking session variables
                unset($_SESSION['rebooking']);
                unset($_SESSION['rebook_id']);
                unset($_SESSION['rebook_original_type']);
            }
        } else {
            // Regular booking process
            $result = processBooking($roomId, $checkinDate, $checkoutDate, $userId, $totalPrice);
            $bookingSuccess = $result['success'];
            $bookingError = $result['error'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dockside Hotel© - Book Your Stay</title>
    <link rel="stylesheet" href="../styles/booking.css" />
    <?php require 'common.php'; ?>
</head>

<body> <?php placeHeader() ?> <main class="container py-5">
        <h1 class="text-center mb-4">Book Your Stay</h1> <?php if ($bookingSuccess): ?>
            <div class="booking-success text-center">
                <div class="alert alert-success p-4" role="alert">
                    <h4 class="alert-heading"><i class="bi bi-check-circle"></i> <?php echo $isRebooking ? 'Rebooking Confirmed!' : 'Booking Confirmed!'; ?></h4>
                    <?php if (!empty($rebookingMessage)): ?>
                        <p><?php echo $rebookingMessage; ?></p>
                    <?php else: ?>
                        <p>Your booking has been successfully confirmed. Thank you for choosing Dockside Hotel.</p>
                    <?php endif; ?>
                    <hr>
                    <p class="mb-0">Check your email for your booking confirmation details.</p>
                    <div class="mt-4"> <a href="home.php" class="btn btn-primary">Return to Home</a>
                        <a href="user_dashboard.php?tab=bookings" class="btn btn-outline-primary ms-2">View My Bookings</a>
                    </div>
                </div>
            </div>
        <?php else: ?> <!-- Search Form -->
            <div class="search-section mb-5" id="search-section"> <?php if ($isRebooking): ?>
                    <div class="alert alert-info mb-4" role="alert">
                        <i class="bi bi-info-circle me-2"></i> <strong>Rebooking in Progress:</strong> You are rebooking your stay. Original room type was: <strong><?php echo htmlspecialchars($_SESSION['rebook_original_type']); ?></strong>. Feel free to select any room type, dates, and room below.
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo $isRebooking ? 'Select New Room & Dates' : 'Search for Availability'; ?></h4>
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
                                <!-- Search button removed - auto-searching with JavaScript -->
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
            <?php endif; ?> <?php if ($selectedRoom): ?>
                <!-- Booking Summary Section -->
                <div class="booking-summary-section mb-5">
                    <h3 class="mb-4">Booking Confirmation</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left side: Room details and features (70%) -->
                                <div class="col-lg-8">
                                    <div class="booking-details p-3">
                                        <h4><?php echo $selectedRoom['room_type']; ?> Details</h4>
                                        <div class="room-image my-3">
                                            <?php
                                                                    // Map room types to the correct image filenames in assets folder
                                                                    switch ($selectedRoom['room_type']) {
                                                                        case 'Presidential Suite':
                                                                            $roomImageFile = 'presidential.jpg';
                                                                            break;
                                                                        case 'Executive Suite':
                                                                            $roomImageFile = 'executive.jpg';
                                                                            break;
                                                                        case 'Deluxe Room':
                                                                            $roomImageFile = 'deluxe.jpg';
                                                                            break;
                                                                        case 'Standard Room':
                                                                        default:
                                                                            $roomImageFile = 'standard.jpg';
                                                                            break;
                                                                    }
                                                                    $roomImagePath = "../assets/" . $roomImageFile;
                                            ?>
                                            <img src="<?php echo $roomImagePath; ?>" class="img-fluid rounded" alt="<?php echo $selectedRoom['room_type']; ?>">
                                        </div>

                                        <div class="room-info">
                                            <?php
                                                                    // Room details based on room type from LORE.md
                                                                    switch ($selectedRoom['room_type']) {
                                                                        case 'Presidential Suite':
                                                                            $roomSize = "200m²";
                                                                            $roomDesc = "Step into a realm of unparalleled opulence within our Presidential Suite, where every detail whispers of exquisite design and indulgent comfort. Floor-to-ceiling windows frame a breathtaking panorama of the endless ocean. The suite includes an expansive living area, gourmet kitchen, elegant dining area, and lavishly appointed bedrooms.";
                                                                            $roomFeatures = ["Infinity Pool", "Ocean View", "Jacuzzi", "65\" Smart TV", "Executive Lounge Access", "High-Speed WiFi", "King Bed", "Sound System", "Digital Safe", "Premium Bar", "Private Terrace", "Business Center", "Climate Control", "IDD Phone"];
                                                                            break;
                                                                        case 'Executive Suite':
                                                                            $roomSize = "100m²";
                                                                            $roomDesc = "Step into a comfortable and stylish retreat where the gentle allure of the coast enhances your stay. Generous windows offer pleasant views of the nearby shoreline. Relax in the tastefully furnished living area, with a convenient fridge, mini-bar and coffee maker for added convenience.";
                                                                            $roomFeatures = ["Ocean View", "55\" Smart TV", "Executive Lounge Access", "High-Speed WiFi", "King Bed", "Work Desk", "Digital Safe", "Mini Bar", "Climate Control", "IDD Phone", "Balcony"];
                                                                            break;
                                                                        case 'Deluxe Room':
                                                                            $roomSize = "45m²";
                                                                            $roomDesc = "Imagine entering a haven of refined comfort, where stylish design meets the soothing rhythm of the sea. Expansive windows unveil captivating vistas of the ocean, inviting the vibrant hues of sunrise and the tranquil glow of twilight into your personal sanctuary.";
                                                                            $roomFeatures = ["Partial Ocean View", "43\" Smart TV", "High-Speed WiFi", "Queen Bed", "Digital Safe", "Coffee Maker", "Climate Control", "IDD Phone", "Mini Bar", "Balcony"];
                                                                            break;
                                                                        case 'Standard Room':
                                                                        default:
                                                                            $roomSize = "30m²";
                                                                            $roomDesc = "Discover a comfortable and well-appointed space designed for a restful stay. Large windows allow natural light to fill the room, creating a bright and welcoming ambiance. Enjoy comfortable bedding, a functional workspace, and a private ensuite bathroom.";
                                                                            $roomFeatures = ["40\" HD TV", "WiFi", "Air Conditioning", "Phone", "Tea Set", "In-Room Safe", "Double Bed", "City View"];
                                                                            break;
                                                                    }
                                            ?>
                                            <div class="room-size my-3">
                                                <h5>Room Specifications</h5>
                                                <p><strong>Room #:</strong> <?php echo $selectedRoom['room_id']; ?></p>
                                                <p><strong>Size:</strong> <?php echo $roomSize; ?></p>
                                                <p><strong>Capacity:</strong> <?php echo $selectedRoom['room_capacity']; ?> guests</p>
                                                <p><strong>Base Rate:</strong> ₱<?php echo number_format($selectedRoom['room_price'], 2); ?> per night</p>
                                            </div>

                                            <div class="room-description my-3">
                                                <h5>Description</h5>
                                                <p><?php echo $roomDesc; ?></p>
                                            </div>

                                            <div class="room-features my-3">
                                                <h5>Room Features</h5>
                                                <div class="row">
                                                    <?php foreach ($roomFeatures as $feature): ?>
                                                        <div class="col-md-6 col-lg-4 mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i><?php echo $feature; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <div class="booking-policy my-3">
                                                <h5>Booking Policies</h5>
                                                <p><i class="bi bi-clock me-2"></i><strong>Check-in:</strong> 3:00 PM</p>
                                                <p><i class="bi bi-clock me-2"></i><strong>Check-out:</strong> 12:00 NN (Philippine Time)</p>
                                                <p><i class="bi bi-exclamation-circle me-2"></i>All cancellations and rebookings are allowed free of charge.</p>
                                            </div>

                                            <div class="stay-details mt-4">
                                                <h5>Your Stay</h5>
                                                <p><i class="bi bi-calendar-check me-2"></i><strong>Check-in Date:</strong> <?php echo $bookingDetails['checkinFormatted']; ?></p>
                                                <p><i class="bi bi-calendar-x me-2"></i><strong>Check-out Date:</strong> <?php echo $bookingDetails['checkoutFormatted']; ?></p>
                                                <p><i class="bi bi-moon me-2"></i><strong>Duration:</strong> <?php echo $bookingDetails['totalNights']; ?> night(s)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- Right side: Price details (30%) -->
                                <div class="col-lg-4">
                                    <div class="card card-body bg-light booking-price-card">
                                        <h4 class="text-center mb-4">Booking Summary</h4>

                                        <!-- Base charges -->
                                        <div class="price-details">
                                            <h5>Room Charges</h5>
                                            <div class="d-flex justify-content-between mt-3">
                                                <span>Base Rate:</span>
                                                <span>₱<?php echo number_format($selectedRoom['room_price'], 2); ?>/night</span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span><?php echo $bookingDetails['totalNights']; ?> Night(s):</span>
                                                <span>₱<?php echo number_format($bookingDetails['totalPrice'], 2); ?></span>
                                            </div>
                                        </div>

                                        <hr class="my-3">

                                        <!-- Additional fees -->
                                        <div class="price-details">
                                            <h5>Additional Charges</h5>
                                            <?php
                                                                    // Calculate additional fees
                                                                    $baseAmount = $bookingDetails['totalPrice'];
                                                                    $serviceCharge = $baseAmount * 0.10;
                                                                    $tourismFee = $bookingDetails['totalNights'] * 150;
                                                                    $roomTax = $baseAmount * 0.12;
                                                                    $environmentalFee = $bookingDetails['totalNights'] * 100;

                                                                    // Calculate total with all fees
                                                                    $totalWithFees = $baseAmount + $serviceCharge + $tourismFee + $roomTax + $environmentalFee;
                                            ?>

                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Service Charge (10%):</span>
                                                <span>₱<?php echo number_format($serviceCharge, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Tourism Fee:</span>
                                                <span>₱<?php echo number_format($tourismFee, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Room Tax (12%):</span>
                                                <span>₱<?php echo number_format($roomTax, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Environmental Fee:</span>
                                                <span>₱<?php echo number_format($environmentalFee, 2); ?></span>
                                            </div>
                                        </div>

                                        <hr class="my-3">

                                        <!-- Total amount -->
                                        <div class="price-details mb-3">
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Total Amount:</span>
                                                <span>₱<?php echo number_format($totalWithFees, 2); ?></span>
                                            </div>
                                        </div>
                                        <div class="payment-note mb-4">
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i> Payment will be collected upon check-in. We accept cash (PHP), major credit/debit cards, GCash/PayMaya, or bank transfers.
                                            </small>
                                        </div>

                                        <!-- Form for booking confirmation -->
                                        <form action="booking.php" method="POST" class="mt-auto" id="booking-confirmation-form">
                                            <input type="hidden" name="room_id" value="<?php echo $selectedRoom['room_id']; ?>">
                                            <input type="hidden" name="checkin" value="<?php echo $checkinDate; ?>">
                                            <input type="hidden" name="checkout" value="<?php echo $checkoutDate; ?>">
                                            <input type="hidden" name="total_price" value="<?php echo $totalWithFees; ?>">
                                            <input type="hidden" name="check_auth" value="1">

                                            <!-- Add the selected_room as a hidden parameter to preserve on form submission -->
                                            <input type="hidden" name="selected_room_param" value="<?php echo $selectedRoom['room_id']; ?>">

                                            <button type="submit" name="confirm_booking" class="btn btn-success w-100">Confirm Booking</button>
                                            <a href="booking.php" class="btn btn-outline-secondary w-100 mt-2" id="back-to-search-btn">
                                                <i class="bi bi-arrow-left me-2"></i>Back to Search
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?> <?php if (!empty($bookingError)): ?>
                <div class="alert alert-danger mb-4" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?php echo $bookingError; ?>
                    <?php if ($selectedRoom): ?>
                        <div class="mt-3">
                            <a href="booking.php" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-arrow-left me-2"></i>Back to Search
                            </a>
                        </div> <?php endif; ?>
                </div>
            <?php endif; ?> <?php endif; ?> <script src="../scripts/booking.js"></script> <?php if ($needAuth): ?> <script>
                // Show the account required dialog when the page loads
                document.addEventListener('DOMContentLoaded', function() {
                    // Simply show the modal - all booking details are already stored in session
                    showAccountRequiredDialog();
                });
            </script>
        <?php endif; ?>
    </main> <?php placeFooter() ?>
</body>

</html>