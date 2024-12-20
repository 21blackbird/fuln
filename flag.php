<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <h1>
        flag{sql1nj3ct3D!}
    </h1>
    <br>
    <script>
        const params = new URLSearchParams(window.location.search);
        const username = params.get('username');
        if (username) {
            document.getElementById('welcomeMessage').textContent = `Welcome, ${username}!`;
        } else {
            document.getElementById('welcomeMessage').textContent = 'Welcome!';
        }
    </script>
</body>
</html>
