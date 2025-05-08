<?php
// database connection settings
$servername = "127.0.0.1:3307";
//$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docksidedb";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get submitted data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // prepare and execute SQL query
        $stmt = $conn->query("SELECT COUNT(*) AS instanceCount FROM $dbname.`person` WHERE 
        pers_email = '$email' AND pers_pass = '$password'");
        $doesExist = $stmt->fetch_assoc();

        if ($doesExist['instanceCount'] != 0) {
            // password matches, redirect to privacy.php (FOR NOW! DEBUG LINE ONLY)
            header("Location: ../pages/privacy.php");
            exit;
        } else {
            // invalid creds, return to login
            $error = "Invalid email or password.";
            header("Location: ../pages/wrong_email_pass.php");
            exit;
        }
    }
} catch (PDOException $e) {
    // handle database connection errors
    $error = "Database error: " . $e->getMessage();
    header("Location: /login.php?error=" . urlencode($error));
    exit;
}
