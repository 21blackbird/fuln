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
    // Todo : Implement security headers to protect against clickjacking attacks, XSS, and ensure all connections are securely enforced over HTTPS using HSTS!
    header ("X-XSS-Protection: 0");
    header("Access-Control-Allow-Origin: *");

    // Todo : To prevent brute-force attacks, Implement a rate-limiting mechanism that temporarily blocks user login attempts after five failed attempts!
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'fuln');
    
    // Todo : Make a secure password when connecting to a database !
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Todo : Implement prepare statements to prevent SQL Injection!
    $result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    
    if ($result->num_rows > 0) {
        header('Location: flag.php?username=' . urlencode(htmlspecialchars($username)));
        exit();
    } else {
        // Todo : make sure the page is not vulnerable to XSS!
        echo "<pre>Login for " . $_POST['username'] . " is invalid!</pre>";
        error_log("unsucessfull login for $username with password $password!");
    }

    $conn->close();
    }
    ?>

</body>
</html>