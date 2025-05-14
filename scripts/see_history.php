<?php
function getUserBookingHistory($userId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    // Query to fetch booking history for a specific user
    $sql = "SELECT b.bkg_id, b.bkg_datein, b.bkg_dateout, b.bkg_totalpr, 
               r.room_id, r.room_type, p.pers_id, CONCAT(p.pers_fname, ' ', p.pers_lname) AS full_name
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id
            JOIN person p ON b.pers_id = p.pers_id
            WHERE b.pers_id = ?
            ORDER BY b.bkg_datein DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    $conn->close();
    return [
        "count" => count($bookings),
        "data" => $bookings
    ];
}

function getRoomBookingHistory($roomId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    // Query to fetch booking history for a specific room
    $sql = "SELECT b.bkg_id, b.bkg_datein, b.bkg_dateout, b.bkg_totalpr, 
               r.room_id, r.room_type, p.pers_id, CONCAT(p.pers_fname, ' ', p.pers_lname) AS full_name
        FROM booking b 
        JOIN room r ON b.room_id = r.room_id
        JOIN person p ON b.pers_id = p.pers_id
        WHERE b.room_id = ? 
        ORDER BY b.bkg_datein DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    $conn->close();
    return [
        'count' => count($bookings),
        'data' => $bookings
    ];
}
