<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Tips - Recipe Finder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/tips.css">
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
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <!-- Cooking Tips Main Section -->
    <main class="tips-section">
        <div class="tips-container">
            <h2>Cooking Tips</h2>
            <p>Discover essential cooking tips and tricks to make your culinary journey easier and more enjoyable!</p>
            <div class="tips-cards">
                <div class="tip-card">
                    <div class="tip-front">
                        <h3>1. Keep Your Knives Sharp</h3>
                    </div>
                    <div class="tip-back">
                        <p>A sharp knife is safer and more efficient than a dull one. Regularly sharpen your knives and use them with caution for better control.</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-front">
                        <h3>2. Read Recipes Thoroughly</h3>
                    </div>
                    <div class="tip-back">
                        <p>Always read through a recipe completely before starting. This will help you gather ingredients and understand the steps.</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-front">
                        <h3>3. Prep Ingredients in Advance</h3>
                    </div>
                    <div class="tip-back">
                        <p>Having all ingredients prepped before cooking (mise en place) will make your process smoother and more enjoyable.</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-front">
                        <h3>4. Taste as You Cook</h3>
                    </div>
                    <div class="tip-back">
                        <p>To get the best flavor, taste your food as you go and adjust seasonings accordingly. This will help you create balanced, flavorful dishes.</p>
                    </div>
                </div>
                <!-- Additional tips can be added here following the same structure -->
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="social-media">
            <a href="#"><img src="./res/svg/instagram.svg" alt="Instagram"></a>
            <a href="#"><img src="./res/svg/twitter.svg" alt="Twitter"></a>
            <a href="#"><img src="./res/svg/pinterest.svg" alt="Pinterest"></a>
        </div>
        <p>&copy; 2024 Recipe Finder. All Rights Reserved.</p>
    </footer>

</body>
</html>
