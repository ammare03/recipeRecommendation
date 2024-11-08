<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Recipes - Recipe Finder</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/recipes.css">
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
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <main>
        <section class="explore-recipes container">
            <h2>Explore Recipes</h2>
            <p>Enter the ingredients you have on hand, and we'll find recipes that include those ingredients!</p>
            <form id="ingredientForm" method="POST">
                <input type="text" id="ingredients" name="ingredients" placeholder="Enter ingredients (comma separated)" required>
                <button type="submit" class="search-btn">Search Recipes</button>
            </form>
        </section>
        
        <section class="results container" id="results">
            <h3>Available Recipes</h3>
            <div id="recipeResults"></div>
        </section>
    </main>

    <script>
    $(document).ready(function() {
        $('.explore-recipes').addClass('visible');
        $('#ingredientForm').on('submit', function(e) {
            e.preventDefault();
            
            var ingredients = $('#ingredients').val();
            
            $.ajax({
                url: 'fetch_recipes.php',
                type: 'POST',
                data: { ingredients: ingredients },
                success: function(response) {
                    $('#recipeResults').html(response);

                    $('html, body').animate({
                        scrollTop: $('#results').offset().top
                    }, 1000);

                    setTimeout(function() {
                        $('.recipe-item').each(function(index) {
                            $(this).addClass('loaded');
                        });
                    }, 400);
                },
                error: function() {
                    $('#recipeResults').html('<p>An error occurred while fetching recipes.</p>');
                }
            });
        });

        $(document).on('click', '.download-recipe-btn', function() {
            const recipeName = $(this).data('name');
            const instructions = $(this).data('instructions');
            const cookingTime = $(this).data('cooking-time');
            const servings = $(this).data('servings');
            
            const textContent = `Recipe: ${recipeName}\n\nInstructions: ${instructions}\n\nCooking Time: ${cookingTime} minutes\nServings: ${servings}`;

            const blob = new Blob([textContent], { type: 'text/plain' });

            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = `${recipeName}.txt`;

            downloadLink.click();
        });
    });
    </script>

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
