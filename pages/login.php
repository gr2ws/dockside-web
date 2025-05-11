<?php
session_start();

require '../scripts/handle_login.php';
require 'common.php';

// Prepare a message variable
$loginMessage = null;

// Check for redirect parameter
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';

// Handle login before output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginMessage = handleLogin($redirect); // update handleLogin to return message or null
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dockside Hotel© | Log In</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body>
    <?php placeHeader() ?>

    <div class="login-body container-fluid my-auto d-flex flex-column justify-center align-items-center">

        <?php
        if ($loginMessage) {
            echo $loginMessage;
        }
        ?>

        <div class="login-container py-4">
            <h1>Sign In</h1>
            <form id="loginForm" method="POST">
                <?php if (!empty($redirect)): ?>
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        maxlength="255"
                        required>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        minlength="8"
                        maxlength="30"
                        required>
                </div>
                <button type="submit" class="login-btn">Sign In</button>
                <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
            </form>
            <div class="or-divider">OR</div>
            <button class="secondary-btn" onclick="window.location.href='./sign_up.php'">Create an Account</button>
        </div>
    </div>

    <script src="../scripts/login.js"></script>
    <?php placeFooter() ?>
</body>

</html>