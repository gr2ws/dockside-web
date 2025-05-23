<?php

date_default_timezone_set('Asia/Manila');


function getUserBookingHistory($userId)
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    // Query to fetch booking history for a specific user
    $SQLcommand = "SELECT b.bkg_id, b.bkg_datein, b.bkg_dateout, b.bkg_totalpr, 
               r.room_id, r.room_type, p.pers_id, CONCAT(p.pers_fname, ' ', p.pers_lname) AS full_name
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id
            JOIN person p ON b.pers_id = p.pers_id
            WHERE b.pers_id = $userId
            ORDER BY b.bkg_datein DESC";

    $result = $conn->query($SQLcommand);

    if (!$result) {
        $conn->close();
        return ["error" => "Query failed: " . $conn->error];
    }

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
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

    // Query to fetch booking history for a specific user
    $SQLcommand = "SELECT b.bkg_id, b.bkg_datein, b.bkg_dateout, b.bkg_totalpr, 
               r.room_id, r.room_type, p.pers_id, CONCAT(p.pers_fname, ' ', p.pers_lname) AS full_name
            FROM booking b 
            JOIN room r ON b.room_id = r.room_id
            JOIN person p ON b.pers_id = p.pers_id
            WHERE b.room_id = $roomId
            ORDER BY b.bkg_datein DESC";

    $result = $conn->query($SQLcommand);

    if (!$result) {
        $conn->close();
        return ["error" => "Query failed: " . $conn->error];
    }

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }

    $conn->close();

    return [
        "count" => count($bookings),
        "data" => $bookings
    ];
}

function getTodaysBookings()
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    // Get today's date in Y-m-d format
    $today = date('Y-m-d');

    $SQLcommand = " SELECT 
            b.bkg_id, 
            b.bkg_datein, 
            b.bkg_dateout, 
            b.bkg_totalpr,
            r.room_id, 
            r.room_type, 
            r.room_capacity, 
            r.room_price,
            p.pers_id,
            CONCAT(p.pers_fname, ' ', p.pers_lname) AS full_name
        FROM booking b
        JOIN room r ON b.room_id = r.room_id
        JOIN person p ON b.pers_id = p.pers_id
        WHERE (b.bkg_datein <= '$today' AND b.bkg_dateout >= '$today')
        ORDER BY b.bkg_id ASC
    ";

    $result = $conn->query($SQLcommand);

    if (!$result) {
        $conn->close();
        return ["error" => "Query failed: " . $conn->error];
    }

    $todayBookings = [];
    while ($row = $result->fetch_assoc()) {
        $todayBookings[] = $row;
    }

    $conn->close();

    return [
        'count' => count($todayBookings),
        'data' => $todayBookings
    ];
}
