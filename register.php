<?php
// Start the session
session_start();
$message = '';

// Database configuration
$host = 'localhost';
$port = 3309; // New port number
$db = 'recipe_finder'; // Replace with your actual database name
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "User registered successfully. You can now log in.";
    } else {
        $message = "Error: " . $stmt->error; // Display error message
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/register.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                Recipe Finder
            </h1>
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
            <form method="POST">
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="register-btn">Register</button>
                <p class="message"><?php echo $message; ?></p>
                <p class="login-message">Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="social-media">
            <a href="#"><img src="./res/svg/instagram.svg" alt="Instagram"></a>
            <a href="#"><img src="./res/svg/twitter.svg" alt="Twitter"></a>
            <a href="#"><img src="./res/svg/pinterest.svg" alt="Pinterest"></a>
        </div>
        <p>&copy; 2023 Recipe Finder. All Rights Reserved.</p>
    </footer>
</body>
</html>
