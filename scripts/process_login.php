<?php
session_start();
// database connection settings
$servername = "127.0.0.1:3307";
//$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docksidedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get submitted data (taken from login.php)
        $email = $_POST['email'];
        $password = $_POST['password'];

        // prepare and execute SQL query
        $stmt = $conn->query("SELECT * FROM $dbname.`person` WHERE 
                 pers_email = '$email' AND pers_pass = '$password'");

        // email/password combo matches. initiate session vars and redirect to relevant page
        if ($stmt->num_rows > 0) {
            $row = $stmt->fetch_assoc();
            // get submitted data (taken from login.php)
            $_SESSION['fname'] = $row['pers_fname'];
            $_SESSION['lname'] = $row['pers_lname'];
            $_SESSION['address'] = $row['pers_address'];
            $_SESSION['phone'] = $row['pers_phone'];
            $_SESSION['birth'] = $row['pers_birthdate'];
            $_SESSION['email'] = $row['pers_email'];
            // not storing password for some security
            header("Location: ../pages/user_dashboard.php");
            exit;
        } else {
            // invalid creds, return to login
            $error = "Invalid email or password.";
            header("Location: ../pages/wrong_email_pass.php");
            exit;
        }
    }
}
