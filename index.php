<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Finder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body class="element">

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
            <a href="index.php" class="active">Home</a>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <main>
        <section class="intro container animate-fade-up">
            <h2>Welcome to Recipe Finder</h2>
            <p>Your go-to solution for discovering and sharing the best recipes based on your preferences and available ingredients. Explore, create, and share recipes with ease!</p>
            <p>With a user-friendly interface and a rich database of culinary delights, you'll never run out of ideas for your next meal. Whether you're a beginner or a seasoned chef, Recipe Finder is here to inspire your culinary journey.</p>

            <a href="recipes.php" class="explore-btn <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? '' : 'disabled'; ?>" 
                onclick="handleLoginClick(event, <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? 'true' : 'false'; ?>)">
                    Explore Recipes
            </a>
            <a href="tips.php" class="tips-btn <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? '' : 'disabled'; ?>" 
                onclick="handleLoginClick(event, <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? 'true' : 'false'; ?>)">
                    Cooking Tips
            </a>
            <br>
            <span id="login-message" class="error-message">Please Login First!</span>
        </section>

        <section class="features animate-fade-up">
            <h2 class="features-title">Features</h2>
            <div class="feature-items">
                <div class="feature-item animate-fade-up">
                    <h3>Search by Ingredients</h3>
                    <p>Enter ingredients you have, and find recipes that match.</p>
                </div>
                <div class="feature-item animate-fade-up">
                    <h3>Personalized Suggestions</h3>
                    <p>Get recipe recommendations based on your taste preferences.</p>
                </div>
                <div class="feature-item animate-fade-up">
                    <h3>Share Your Recipes</h3>
                    <p>Have a great recipe? Share it with the community!</p>
                </div>
            </div>
        </section>

        <section class="testimonials container animate-fade-up">
            <h2>What Our Users Say</h2>
            <div class="testimonial-items">
                <div class="card animate-fade-up">
                    <img src="./res/images/sarahK.jpeg" class="card-img-top" alt="User Image">
                    <div class="card-body">
                        <h5 class="card-title">Sarah K.</h5>
                        <p class="card-text">"Recipe Finder has completely transformed my cooking! I find new recipes every week!"</p>
                    </div>
                </div>
                <div class="card animate-fade-up">
                    <img src="./res/images/mikeT.jpg" class="card-img-top" alt="User Image">
                    <div class="card-body">
                        <h5 class="card-title">Mike T.</h5>
                        <p class="card-text">"The Cooking Tips have helped me boost my skills tremendously!"</p>
                    </div>
                </div>
                <div class="card animate-fade-up">
                    <img src="./res/images/emilyR.avif" class="card-img-top" alt="User Image">
                    <div class="card-body">
                        <h5 class="card-title">Emily R.</h5>
                        <p class="card-text">"The search by ingredients feature saved me from food waste! Highly recommend!"</p>
                    </div>
                </div>
                <div class="card animate-fade-up">
                    <img src="./res/images/johnD.jpg" class="card-img-top" alt="User Image">
                    <div class="card-body">
                        <h5 class="card-title">John D.</h5>
                        <p class="card-text">"Thanks to Recipe Finder, I have learned to experiment with new ingredients and flavors!"</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="social-media">
            <a href="#"><img src="./res/svg/instagram.svg" alt="Instagram"></a>
            <a href="#"><img src="./res/svg/twitter.svg" alt="Twitter"></a>
            <a href="#"><img src="./res/svg/pinterest.svg" alt="Pinterest"></a>
        </div>
        <p>&copy; 2024 Recipe Finder. All Rights Reserved.</p>
    </footer>

    <script>
        function handleLoginClick(event, isLoggedIn) {
            const loginMessage = document.getElementById("login-message");

            if (!isLoggedIn) {
                loginMessage.classList.add("visible");
                event.preventDefault();
            } else {
                loginMessage.classList.remove("visible");
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            function isInView(element) {
                var elementTop = $(element).offset().top;
                var elementBottom = elementTop + $(element).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                return elementBottom > viewportTop && elementTop < viewportBottom;
            }

            function handleScroll() {
                $('.animate-fade-up').each(function() {
                    if (isInView(this)) {
                        $(this).addClass('visible');
                    }
                });
            }

            handleScroll();

            $(window).on('scroll', function() {
                handleScroll();
            });
        });
    </script>

</body>
</html>
