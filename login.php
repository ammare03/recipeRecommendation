<?php
session_start();
$message = '';

// Database configuration
$host = 'localhost';
$port = 3309;
$db = 'recipe_finder';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password input
    if (empty($email) || empty($password)) {
        $message = 'Please fill in all fields.';
    } elseif (!preg_match($emailPattern, $email)) {
        $message = 'Invalid email format.';
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_logged_in'] = true;
                header("Location: index.php");
                exit();
            } else {
                $message = 'Invalid password.';
            }
        } else {
            $message = 'No user found with that email.';
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recipe Finder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./scripts/login.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <h1>Recipe Finder</h1>
        </div>
        <div class="nav-right">
            <a href="index.php">Home</a>
            <a href="login.php" class="active">Login</a>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <section class="login-container container">
            <h2>Login</h2>
            <form method="POST" id="loginForm" novalidate>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit" class="login-btn">Login</button>
                <p class="message"><?php echo $message; ?></p>
                <p class="register-message">Don't have an account? <a href="register.php">Register here</a></p>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Recipe Finder. All Rights Reserved.</p>
    </footer>

</body>
</html>
