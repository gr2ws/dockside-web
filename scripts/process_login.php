<?php
// database connection settings
$host = 'localhost'; 
$dbname = 'dbatabase'; 
$username = 'username'; 
$password = 'password'; 

try {
    // create  new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get submitted data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // prepare and execute SQL query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // password matches, redirect to index.html
            header("Location: index.html");
            exit;
        } else {
            // invalid creds, return to login
            $error = "Invalid email or password.";
            header("Location: /login.php?error=" . urlencode($error));
            exit;
        }
    }
} catch (PDOException $e) {
    // handle database connection errors
    $error = "Database error: " . $e->getMessage();
    header("Location: /login.php?error=" . urlencode($error));
    exit;
}
?>