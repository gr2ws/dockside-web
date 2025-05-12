<?php
// filepath: c:\xampp\htdocs\dockside-web\scripts\handle_userinfo.php

require_once __DIR__ . '/setup_vars.php';

/**
 * Get user's booking history with pagination
 * 
 * @param int $userId The user ID
 * @param int $limit Number of records to return (default 10)
 * @param int $offset Starting position (default 0)
 * @return array Array of booking history
 */
function getUserBookingHistory($userId, $limit = 10, $offset = 0)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user's booking history with room details
    $sql = "SELECT b.*, r.room_type, r.room_capacity 
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id 
            WHERE b.pers_id = ? 
            ORDER BY b.bkg_datein DESC
            LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $userId, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookingHistory = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add a flag to indicate if this booking is in the past
            $row['is_past'] = (strtotime($row['bkg_dateout']) < time());
            $bookingHistory[] = $row;
        }
    }

    // Get total booking count for pagination
    $countSql = "SELECT COUNT(*) as total FROM booking WHERE pers_id = ?";
    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param("i", $userId);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalBookings = $countResult->fetch_assoc()['total'];

    $conn->close();
    return [
        'bookings' => $bookingHistory,
        'total' => $totalBookings
    ];
}

/**
 * Get user's booking statistics
 * 
 * @param int $userId The user ID
 * @return array Booking statistics
 */
function getUserBookingStats($userId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stats = [
        'total_bookings' => 0,
        'upcoming_bookings' => 0,
        'completed_bookings' => 0,
        'favorite_room_type' => 'N/A',
        'total_spent' => 0,
        'avg_stay_duration' => 0,
        'longest_stay' => 0,
        'first_booking' => null,
        'last_booking' => null,
    ];

    // Current date for comparison
    $currentDate = date('Y-m-d');

    // Get total bookings count
    $sql = "SELECT COUNT(*) as total FROM booking WHERE pers_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['total_bookings'] = (int)$row['total'];
    }

    // Get upcoming bookings count (check-in date is in the future)
    $sql = "SELECT COUNT(*) as upcoming FROM booking WHERE pers_id = ? AND bkg_datein >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['upcoming_bookings'] = (int)$row['upcoming'];
    }

    // Get completed bookings count (check-out date is in the past)
    $sql = "SELECT COUNT(*) as completed FROM booking WHERE pers_id = ? AND bkg_dateout < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['completed_bookings'] = (int)$row['completed'];
    }

    // Get favorite room type (most booked)
    $sql = "SELECT r.room_type, COUNT(*) as booking_count 
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id 
            WHERE b.pers_id = ? 
            GROUP BY r.room_type 
            ORDER BY booking_count DESC 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['favorite_room_type'] = $row['room_type'];
    }

    // Calculate total amount spent
    $sql = "SELECT SUM(bkg_totalpr) as total_spent FROM booking WHERE pers_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['total_spent'] = (float)$row['total_spent'];
    }

    // Calculate average stay duration and longest stay
    $sql = "SELECT 
            AVG(DATEDIFF(bkg_dateout, bkg_datein)) as avg_stay,
            MAX(DATEDIFF(bkg_dateout, bkg_datein)) as longest_stay,
            MIN(bkg_datein) as first_booking,
            MAX(bkg_datein) as last_booking
            FROM booking 
            WHERE pers_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stats['avg_stay_duration'] = round((float)$row['avg_stay'], 1);
        $stats['longest_stay'] = (int)$row['longest_stay'];
        $stats['first_booking'] = $row['first_booking'];
        $stats['last_booking'] = $row['last_booking'];
    }

    // Room type distribution
    $sql = "SELECT r.room_type, COUNT(*) as count 
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id 
            WHERE b.pers_id = ? 
            GROUP BY r.room_type 
            ORDER BY count DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $roomTypeDistribution = [];
    while ($row = $result->fetch_assoc()) {
        $roomTypeDistribution[] = [
            'room_type' => $row['room_type'],
            'count' => (int)$row['count']
        ];
    }

    $stats['room_type_distribution'] = $roomTypeDistribution;

    $conn->close();
    return $stats;
}
