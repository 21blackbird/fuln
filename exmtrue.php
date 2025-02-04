<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <p class="error-message" id="errorMessage"></p>
        </form>
    </div>

    <?php
    session_start();

    // Security Headers
    header("Content-Security-Policy: default-src 'self'");
    header("X-Frame-Options: DENY");
    header("X-XSS-Protection: 1; mode=block");
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    header("Access-Control-Allow-Origin: 'none'");

    // Brute-force protection - Lockout after 5 failed attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= 5) {
        die('Too many failed login attempts. Try again later.');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = new mysqli('localhost', 'root', 'secure_password', 'fuln');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['login_attempts'] = 0; // Reset on success
            header('Location: flag.php?username=' . urlencode(htmlspecialchars($username)));
            exit();
        } else {
            $_SESSION['login_attempts'] += 1;
            echo '<pre>Invalid login attempt.</pre>';
            error_log("Unsuccessful login for user: $username");
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
