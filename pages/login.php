<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dockside Hotel© | Log In</title>
    <link rel="stylesheet" href="../styles/login.css">
    <?php require 'common.php' ?>
</head>

<body>
    <?php placeHeader() ?>

    <div class="login-body container-fluid my-auto">
        <div class="login-container py-4">
            <h1>Sign In</h1>
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <form id="loginForm" action="../scripts/process_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="login-btn">Sign In</button>
                <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
            </form>
            <div class="or-divider">OR</div>
            <button class="secondary-btn" onclick="window.location.href='signUp.php'">Create an Account</button>
        </div>
    </div>

    <script src="../scripts/login.js"></script>
    <?php placeFooter() ?>
</body>

</html>