<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ingredients'])) {
    // Sanitize and get ingredients
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
    
    // Split ingredients into an array
    $ingredientArray = array_map('trim', explode(',', $ingredients));
    
    // Prepare the ingredient placeholders for the SQL query
    $placeholders = implode(',', array_fill(0, count($ingredientArray), '?'));
    
    // Prepare the SQL statement to find recipes based on ingredients
    $sql = "SELECT r.id, r.name, r.instructions, r.cooking_time, r.servings
            FROM recipes r
            JOIN recipe_ingredients ri ON r.id = ri.recipe_id
            JOIN ingredients i ON ri.ingredient_id = i.id
            WHERE i.name IN ($placeholders)
            GROUP BY r.id
            HAVING COUNT(DISTINCT i.id) = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Create an array for the parameters
    $paramTypes = str_repeat('s', count($ingredientArray)) . 'i'; // String types for ingredients and int for count
    $params = array_merge($ingredientArray, [count($ingredientArray)]); // Merge the ingredient array with count
    
    // Bind the parameters
    $stmt->bind_param($paramTypes, ...$params);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Prepare the response in HTML format
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipeName = htmlspecialchars($row['name']);
            $instructions = htmlspecialchars($row['instructions']);
            $cookingTime = htmlspecialchars($row['cooking_time']);
            $servings = htmlspecialchars($row['servings']);
            
            echo '<div class="recipe-item">';
            echo "<h4>$recipeName</h4>";
            echo "<p>$instructions</p>";
            echo "<p><strong>Cooking Time:</strong> $cookingTime minutes</p>";
            echo "<p><strong>Servings:</strong> $servings</p>";
            
            // Button with data attributes for JavaScript
            echo "<button class='download-recipe-btn' data-name='$recipeName' data-instructions='$instructions' data-cooking-time='$cookingTime' data-servings='$servings'>Download $recipeName</button>";
            echo '</div>';
        }
    } else {
        echo '<p>No recipes found for the provided ingredients.</p>';
    }
    
    $stmt->close();
}

$conn->close();
?>
