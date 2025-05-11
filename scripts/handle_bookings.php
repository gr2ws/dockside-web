<?php
// filepath: c:\xampp\htdocs\dockside-web\scripts\handle_bookings.php

require_once __DIR__ . '/setup_vars.php';

/**
 * Get all bookings for a user
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

    // Get user bookings with room details
    $sql = "SELECT b.*, r.room_type, r.room_capacity 
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id 
            WHERE b.pers_id = ? 
            ORDER BY b.bkg_datein DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
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
            $updateRoomStmt = $conn->prepare("UPDATE room SET room_avail = 'vacant', booking_id = NULL WHERE room_id = ?");
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
