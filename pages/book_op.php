<?php
header('Content-Type: application/json');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

function getConnection()
{
    $host = 'localhost';
    $dbname = 'hotel_db';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        return null;
    }
}

try {
    $conn = getConnection();
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    $action = $_POST['action'] ?? 'list';
    $userId = $_SESSION['user_id'];

    switch ($action) {
        case 'create':
            // Create new booking
            $roomId = $_POST['room_id'] ?? null;
            $checkIn = $_POST['check_in'] ?? null;
            $checkOut = $_POST['check_out'] ?? null;

            if (!$roomId || !$checkIn || !$checkOut) {
                throw new Exception('Missing required fields');
            }

            // Check if room is available
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM bookings 
                WHERE room_id = ? AND 
                ((check_in BETWEEN ? AND ?) OR 
                (check_out BETWEEN ? AND ?) OR
                (check_in <= ? AND check_out >= ?))
            ");
            $stmt->execute([$roomId, $checkIn, $checkOut, $checkIn, $checkOut, $checkIn, $checkOut]);

            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Room is not available for selected dates');
            }

            // Create booking
            $stmt = $conn->prepare("
                INSERT INTO bookings (user_id, room_id, check_in, check_out, status)
                VALUES (?, ?, ?, ?, 'confirmed')
            ");
            $stmt->execute([$userId, $roomId, $checkIn, $checkOut]);

            // Log activity
            $stmt = $conn->prepare("
                INSERT INTO user_activities (user_id, activity_type, description)
                VALUES (?, 'booking', 'Created new booking for room #' || ?)
            ");
            $stmt->execute([$userId, $roomId]);

            echo json_encode(['success' => true, 'message' => 'Booking created successfully']);
            break;

        case 'list':
            // List user's bookings
            $stmt = $conn->prepare("
                SELECT b.*, r.room_type, r.rate
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC
            ");
            $stmt->execute([$userId]);
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $bookings]);
            break;

        case 'cancel':
            // Cancel booking
            $bookingId = $_POST['booking_id'] ?? null;
            if (!$bookingId) {
                throw new Exception('Booking ID is required');
            }

            // Verify booking belongs to user
            $stmt = $conn->prepare("
                SELECT id FROM bookings 
                WHERE id = ? AND user_id = ?
            ");
            $stmt->execute([$bookingId, $userId]);
            if (!$stmt->fetch()) {
                throw new Exception('Booking not found');
            }

            // Cancel booking
            $stmt = $conn->prepare("
                UPDATE bookings 
                SET status = 'cancelled', 
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $stmt->execute([$bookingId]);

            // Log activity
            $stmt = $conn->prepare("
                INSERT INTO user_activities (user_id, activity_type, description)
                VALUES (?, 'cancellation', 'Cancelled booking #' || ?)
            ");
            $stmt->execute([$userId, $bookingId]);

            echo json_encode(['success' => true, 'message' => 'Booking cancelled successfully']);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
