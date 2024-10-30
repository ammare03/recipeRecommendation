<?php
session_start();
$message = '';

// Database configuration
$host = 'localhost';
$port = 3309;
$db = 'recipe_finder';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define regex patterns
$emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if (empty($email) || empty($password)) {
        $message = 'Please fill in all fields.';
    } elseif (!preg_match($emailPattern, $email)) {
        $message = 'Invalid email format.';
    } elseif (!preg_match($passwordPattern, $password)) {
        $message = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    } else {
        // Check if email already exists
        $checkEmailStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            $message = "A user with that email already exists. Change the email or please log in!";
        } else {
            // If email is unique, proceed with registration
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "User registered successfully. You can now log in.";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $checkEmailStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Recipe Finder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/register.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./scripts/register.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <h1>Recipe Finder</h1>
        </div>
        <div class="nav-right">
            <a href="index.php">Home</a>
            <a href="register.php" class="active">Register</a>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <main>
        <section class="register-container container">
            <h2>Register</h2>
            <form method="POST" id="registerForm" novalidate>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit" class="register-btn">Register</button>
                <p class="message"><?php echo $message; ?></p>
                <p class="login-message">Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Recipe Finder. All Rights Reserved.</p>
    </footer>
</body>
</html>
