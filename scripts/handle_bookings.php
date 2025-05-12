<?php
// filepath: c:\xampp\htdocs\dockside-web\scripts\handle_bookings.php

require_once __DIR__ . '/setup_vars.php';

/**
 * Get current and upcoming bookings for a user
 * 
 * @param int $userId The user ID
 * @return array Array of bookings
 */
function getUserBookings($userId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get only current and upcoming bookings (exclude past bookings)
    $currentDate = date('Y-m-d');
    $sql = "SELECT b.*, r.room_type, r.room_capacity 
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id 
            WHERE b.pers_id = ? 
            AND b.bkg_dateout >= ?
            ORDER BY b.bkg_datein ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    $conn->close();
    return $bookings;
}

/**
 * Check if user is logged in and redirect if not
 * 
 * @param string $redirectUrl URL to redirect to after login
 * @return bool True if user is logged in
 */
function checkBookingAuthentication($redirectUrl = '')
{
    // Check if user is logged in - more robust check to ensure valid session
    $isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id']);    // Redirect to login if user is not authenticated
    if (!$isLoggedIn) {
        $_SESSION['booking_error'] = "You must be logged in to book a room online.";
        header("Location: login.php?redirect=" . urlencode($redirectUrl));
        exit;
    }

    return true;
}

/**
 * Check if a booking can be cancelled
 * 
 * @param string $checkinDate Check-in date
 * @return bool True if booking can be cancelled
 */
function canCancelBooking($checkinDate)
{
    $today = new DateTime();
    $checkin = new DateTime($checkinDate);

    // Allow cancellation if check-in is at least 3 days away
    $diff = $today->diff($checkin);
    return $diff->days >= 3;
}

/**
 * Cancel a booking
 * 
 * @param int $bookingId The booking ID
 * @return bool|string True on success, error message on failure
 */
function cancelBooking($bookingId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        return "Connection failed: " . $conn->connect_error;
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Get room ID for this booking
        $stmt = $conn->prepare("SELECT room_id FROM booking WHERE bkg_id = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $roomId = $row['room_id'];

            // Update room status to vacant
            $updateRoomStmt = $conn->prepare("UPDATE room SET room_avail = 'vacant' WHERE room_id = ?");
            $updateRoomStmt->bind_param("i", $roomId);
            $updateRoomStmt->execute();

            // Delete the booking
            $deleteStmt = $conn->prepare("DELETE FROM booking WHERE bkg_id = ?");
            $deleteStmt->bind_param("i", $bookingId);
            $deleteStmt->execute();

            // Commit transaction
            $conn->commit();
            return true;
        } else {
            throw new Exception("Booking not found");
        }
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn->close();
    }
}

/**
 * Get available rooms based on search criteria
 * 
 * @param string $checkin Check-in date (YYYY-MM-DD)
 * @param string $checkout Check-out date (YYYY-MM-DD)
 * @param string $roomType Optional room type filter
 * @return array Available rooms
 */
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
                )";
        // Add room type filter if provided
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

/**
 * Calculate booking details (nights, total price)
 * 
 * @param string $checkinDate Check-in date (YYYY-MM-DD)
 * @param string $checkoutDate Check-out date (YYYY-MM-DD)
 * @param array $room Room details array
 * @return array Booking details
 */
function calculateBookingDetails($checkinDate, $checkoutDate, $room = null)
{
    $details = [
        'totalNights' => 0,
        'totalPrice' => 0,
        'checkinFormatted' => '',
        'checkoutFormatted' => ''
    ];

    if (!empty($checkinDate) && !empty($checkoutDate)) {
        $checkin = new DateTime($checkinDate);
        $checkout = new DateTime($checkoutDate);
        $details['totalNights'] = $checkout->diff($checkin)->days;
        $details['checkinFormatted'] = $checkin->format('F j, Y');
        $details['checkoutFormatted'] = $checkout->format('F j, Y');

        if ($room && isset($room['room_price'])) {
            $details['totalPrice'] = $room['room_price'] * $details['totalNights'];
        }
    }

    return $details;
}

/**
 * Process a new booking
 * 
 * @param int $roomId Room ID
 * @param string $checkinDate Check-in date (YYYY-MM-DD)
 * @param string $checkoutDate Check-out date (YYYY-MM-DD)
 * @param int $userId User ID
 * @param float $totalPrice Total booking price
 * @return array Result of booking operation
 */
function processBooking($roomId, $checkinDate, $checkoutDate, $userId, $totalPrice)
{
    $result = [
        'success' => false,
        'error' => ''
    ];

    // Validate user ID
    if (!$userId || $userId <= 0) {
        $result['error'] = "Invalid user account. Please log out and log in again.";
        return $result;
    }

    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        $result['error'] = "Connection failed: " . $conn->connect_error;
        return $result;
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Check if user ID exists in person table
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
            $bookingId = $conn->insert_id;            // Update room availability
            $updateStmt = $conn->prepare("UPDATE room SET room_avail = 'occupied' WHERE room_id = ?");
            $updateStmt->bind_param("i", $roomId);

            if ($updateStmt->execute()) {
                $conn->commit();
                $result['success'] = true;
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
            $result['error'] = $e->getMessage() . " - Database error: " . $conn->error;
        } else {
            $result['error'] = $e->getMessage();
        }
    }

    $conn->close();
    return $result;
}

/**
 * Validate booking dates
 * 
 * @param string $checkinDate Check-in date
 * @param string $checkoutDate Check-out date
 * @return array Validation result with success flag and error message
 */
function validateBookingDates($checkinDate, $checkoutDate)
{
    $result = [
        'valid' => true,
        'error' => ''
    ];

    // Check if dates are empty
    if (empty($checkinDate) || empty($checkoutDate)) {
        $result['valid'] = false;
        $result['error'] = 'Both check-in and check-out dates are required.';
        return $result;
    }

    try {
        $today = new DateTime();
        $today->setTime(0, 0, 0); // Set to beginning of day for comparison

        $checkin = new DateTime($checkinDate);
        $checkout = new DateTime($checkoutDate);

        // Check if check-in date is in the past
        if ($checkin < $today) {
            $result['valid'] = false;
            $result['error'] = 'Check-in date cannot be in the past.';
            return $result;
        }

        // Check if check-out date is before check-in date
        if ($checkout <= $checkin) {
            $result['valid'] = false;
            $result['error'] = 'Check-out date must be after check-in date.';
            return $result;
        }

        // Check if stay is longer than maximum allowed (e.g., 30 days)
        $daysDiff = $checkout->diff($checkin)->days;
        if ($daysDiff > 30) {
            $result['valid'] = false;
            $result['error'] = 'Bookings cannot exceed 30 days.';
            return $result;
        }
    } catch (Exception $e) {
        $result['valid'] = false;
        $result['error'] = 'Invalid date format.';
        return $result;
    }

    return $result;
}

/**
 * Format currency amount
 * 
 * @param float $amount Amount to format
 * @return string Formatted currency string
 */
function formatCurrency($amount)
{
    return '₱' . number_format($amount, 2);
}

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
            $checkinDate = $row['bkg_datein'];

            if (canCancelBooking($checkinDate)) {
                $cancelResult = cancelBooking($bookingId);
                if ($cancelResult === true) {
                    $_SESSION['booking_message'] = "Your booking has been successfully cancelled.";
                    $_SESSION['booking_status'] = "success";
                } else {
                    $_SESSION['booking_message'] = "Error cancelling booking: " . $cancelResult;
                    $_SESSION['booking_status'] = "danger";
                }
            } else {
                $_SESSION['booking_message'] = "Bookings can only be cancelled at least 3 days before check-in.";
                $_SESSION['booking_status'] = "warning";
            }
        } else {
            $_SESSION['booking_message'] = "Invalid booking or permission denied.";
            $_SESSION['booking_status'] = "danger";
        }

        $conn->close();
    }

    // Redirect back to dashboard
    header("Location: ../pages/user_dashboard.php?tab=bookings");
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
            $checkinDate = $booking['bkg_datein'];

            if (canCancelBooking($checkinDate)) {                // Store booking data in session for rebooking
                $_SESSION['rebooking'] = true;
                $_SESSION['rebook_id'] = $bookingId;
                // Don't force the same room type to allow switching rooms
                $_SESSION['rebook_original_type'] = $booking['room_type'];

                // Redirect to booking page without room type to allow selection of any room type
                header("Location: ../pages/booking.php");
                exit;
            } else {
                $_SESSION['booking_message'] = "Bookings can only be changed at least 3 days before check-in.";
                $_SESSION['booking_status'] = "warning";
                header("Location: ../pages/user_dashboard.php?tab=bookings");
                exit;
            }
        } else {
            $_SESSION['booking_message'] = "Invalid booking or permission denied.";
            $_SESSION['booking_status'] = "danger";
            header("Location: ../pages/user_dashboard.php?tab=bookings");
            exit;
        }

        $conn->close();
    }
}
