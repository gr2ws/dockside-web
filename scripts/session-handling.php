<?php
session_start();

// Database connection configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hotel_db');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Database connection function
function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        error_log("Connection failed: " . $e->getMessage());
        return null;
    }
}

// Get user details
function getUserDetails($userId) {
    try {
        $conn = getConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        $stmt = $conn->prepare("
            SELECT id, username, first_name, last_name, email, phone, address, profile_photo 
            FROM users 
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        error_log("Error fetching user details: " . $e->getMessage());
        return null;
    }
}

// Get user's recent activities
function getRecentActivities($userId, $limit = 5) {
    try {
        $conn = getConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        $stmt = $conn->prepare("
            SELECT activity_type, description, created_at 
            FROM user_activities 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        error_log("Error fetching activities: " . $e->getMessage());
        return [];
    }
}

// Get user's reservations
function getUserReservations($userId) {
    try {
        $conn = getConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        $stmt = $conn->prepare("
            SELECT 
                b.id,
                r.room_type,
                b.check_in,
                b.check_out,
                b.status,
                b.created_at
            FROM bookings b
            JOIN rooms r ON b.room_id = r.id
            WHERE b.user_id = ?
            ORDER BY b.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        error_log("Error fetching reservations: " . $e->getMessage());
        return [];
    }
}

// Get available rooms
function getAvailableRooms() {
    try {
        $conn = getConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        $stmt = $conn->query("
            SELECT 
                r.*,
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        error_log("Error fetching rooms: " . $e->getMessage());
        return [];
    }
}

// Get user data
$userId = $_SESSION['user_id'];
$userDetails = getUserDetails($userId);
$userName = $userDetails ? ($userDetails['first_name'] . ' ' . $userDetails['last_name']) : 'User';
$recentActivities = getRecentActivities($userId);
$userReservations = getUserReservations($userId);
$availableRooms = getAvailableRooms();

// Handle AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'updateProfile':
            // Handle profile update
            $response = ['success' => false, 'message' => 'Not implemented'];
            break;
            
        case 'updatePassword':
            // Handle password update
            $response = ['success' => false, 'message' => 'Not implemented'];
            break;
            
        case 'updateSettings':
            // Handle settings update
            $response = ['success' => false, 'message' => 'Not implemented'];
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Include the HTML template
require_once 'templates/user-dashboard-template.php';
?>