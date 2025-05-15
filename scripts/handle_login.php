<?php
// Note: session_start() should be called by the including file before including this file

require_once __DIR__ . '/setup_vars.php';


function handleLogin()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $pass  = $_POST['password'] ?? '';

        // Get database config and establish connection
        $dbConfig = getDbConfig();
        try {
            $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);
        } catch (Exception $e) {
            # Inline bootstrap svg to fix issues when echoed in login page
            return '<div class="alert alert-danger d-flex align-items-center mb-3 mt-3 w-100 max-w-md" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-database-slash mx-2" viewBox="0 0 16 16">
                <path d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465m-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95Z"/>
                <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
                </svg>
                <div>
                    Database connection error. Please try again later.
                </div>
            </div>';
        }

        // Validate user credentials and get full row
        $sql = "SELECT * FROM person WHERE pers_email = '$email' AND pers_pass = '$pass'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Store user info in session
            $_SESSION['id']       = $user['pers_id'];
            $_SESSION['fname']    = $user['pers_fname'];
            $_SESSION['lname']    = $user['pers_lname'];
            $_SESSION['address']  = $user['pers_address'];
            $_SESSION['phone']    = $user['pers_number'];
            $_SESSION['birthday'] = $user['pers_birthdate'];
            $_SESSION['email']    = $user['pers_email'];
            $_SESSION['pass']     = $user['pers_pass'];
            $_SESSION['role']     = $user['pers_role'];            // Check if there's a pending booking that needs to be processed
            $hasBookingDetails = isset($_SESSION['pending_booking_details']) &&
                $_SESSION['pending_booking_details']['requires_auth'] === true;

            if ($hasBookingDetails) {
                // Set a flag to indicate successful login for booking flow
                $_SESSION['from_booking_flow'] = true;

                // Redirect to booking page to complete the booking process
                header("Location: ../pages/booking.php");
                exit;
            }

            // Default redirects if no booking details in session
            if ($_SESSION['role'] == 'ADMN') {
                header("Location: ../pages/admin_dashboard.php");
            } else {
                header("Location: ../pages/user_dashboard.php");
            }
            exit;
        } else {
            // invalid credentials
            return '<div class="alert alert-danger d-flex align-items-center mb-3 mt-3 w-100 max-w-md" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle mx-2" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
                <div>
                    Incorrect username or password. Please try again.
                </div>
            </div>';
        }
    }
}
