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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'fuln');
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check for matching username and password in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login, redirect to flag.php
        header('Location: flag.php?username=' . urlencode($username));
        exit();
    } else {
        echo "<h1>Invalid login. Please check your username and password.</h1>";
    }

    $conn->close();
    }
    ?>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            // event.preventDefault(); // Prevent the form from submitting normally

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Basic validation
            if (!username || !password) {
                errorMessage.textContent = 'Please fill in all fields.';
                alert('Please fill in all fields');
                return;
            }

            else{
                errorMessage.textContent = ''; // Clear any previous error message
                alert('Login successful!');
            }
        });
    </script>

</body>
</html>