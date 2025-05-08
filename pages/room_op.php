<?php
header('Content-Type: application/json');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

function getConnection() {
    $host = 'localhost';
    $dbname = 'hotel_db';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        return null;
    }
}

try {
    $conn = getConnection();
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    $action = $_GET['action'] ?? 'list';

    switch($action) {
        case 'list':
            // List all available rooms
            $stmt = $conn->query("
                SELECT r.*, 
                    CASE 
                        WHEN b.room_id IS NULL THEN 'Available'
                        ELSE 'Booked'
                    END as status
                FROM rooms r
                LEFT JOIN bookings b ON r.id = b.room_id 
                    AND CURRENT_DATE BETWEEN b.check_in AND b.check_out
                WHERE b.room_id IS NULL
                ORDER BY r.room_type
            ");
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $rooms]);
            break;

        case 'check':
            // Check room availability for specific dates
            $roomId = $_GET['room_id'] ?? null;
            $checkIn = $_GET['check_in'] ?? null;
            $checkOut = $_GET['check_out'] ?? null;

            if (!$roomId || !$checkIn || !$checkOut) {
                throw new Exception('Missing required parameters');
            }

            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM bookings 
                WHERE room_id = ? AND 
                ((check_in BETWEEN ? AND ?) OR 
                (check_out BETWEEN ? AND ?) OR
                (check_in <= ? AND check_out >= ?))
            ");
            $stmt->execute([$roomId, $checkIn, $checkOut, $checkIn, $checkOut, $checkIn, $checkOut]);
            
            $isBooked = $stmt->fetchColumn() > 0;
            echo json_encode(['success' => true, 'available' => !$isBooked]);
            break;

        case 'details':
            // Get room details
            $roomId = $_GET['room_id'] ?? null;
            if (!$roomId) {
                throw new Exception('Room ID is required');
            }

            $stmt = $conn->prepare("
                SELECT r.*, 
                    CASE 
                        WHEN b.room_id IS NULL THEN 'Available'
                        ELSE 'Booked'
                    END as status
                FROM rooms r
                LEFT JOIN bookings b ON r.id = b.room_id 
                    AND CURRENT_DATE BETWEEN b.check_in AND b.check_out
                WHERE r.id = ?
            ");
            $stmt->execute([$roomId]);
            $room = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$room) {
                throw new Exception('Room not found');
            }
            
            echo json_encode(['success' => true, 'data' => $room]);
            break;

        default:
            throw new Exception('Invalid action');
    }

} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>