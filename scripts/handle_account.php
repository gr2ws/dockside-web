<?php
session_start();
require_once __DIR__ . '/setup_vars.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    // Verify password
    $password_confirm = $_POST['password_confirm'] ?? '';
    $user_id = $_SESSION['id'];
    $stored_password = $_SESSION['pass'];    // Check if password matches
    if ($password_confirm === $stored_password) {
        // Delete the account
        if (deleteUserAccount($user_id)) {
            // Store message in session for login page
            session_regenerate_id(true);
            $_SESSION = array();
            $_SESSION['account_deleted'] = true;
            $_SESSION['deletion_message'] = "Your account has been successfully deleted.";
            header("Location: ../pages/login.php");
            exit;
        } else {
            // If deletion fails, redirect back with error
            $_SESSION['account_message'] = "Account deletion failed. Please try again.";
            $_SESSION['account_status'] = "danger";
            header("Location: ../pages/user_dashboard.php#settings");
            exit;
        }
    } else {
        // Password doesn't match - provide a more specific error message
        $_SESSION['account_message'] = "Account deletion was canceled due to incorrect password.";
        $_SESSION['account_status'] = "danger";
        // Set specific wrong password message for the modal
        $_SESSION['wrong_password_message'] = "The password you entered is incorrect. Please try again.";
        // Add a parameter to show modal again when redirected
        header("Location: ../pages/user_dashboard.php?show_delete_modal=1#settings");
        exit;
    }
}

// Function to delete user account
function deleteUserAccount($user_id)
{
    // Get database configuration
    $dbConfig = getDbConfig();

    // Connect to database
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    if ($conn->connect_error) {
        return false;
    }

    // Begin transaction to ensure data integrity
    $conn->begin_transaction();

    try {
        // First delete any bookings associated with the user
        $stmt = $conn->prepare("DELETE FROM booking WHERE pers_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Then delete the user from person table
        $stmt = $conn->prepare("DELETE FROM person WHERE pers_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        $conn->close();
        return true;
    } catch (Exception $e) {
        // Rollback in case of error
        $conn->rollback();
        $conn->close();
        return false;
    }
}
