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
            echo '<div class="recipe-item">';
            echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
            echo '<p>' . htmlspecialchars($row['instructions']) . '</p>';
            echo '<p><strong>Cooking Time:</strong> ' . htmlspecialchars($row['cooking_time']) . ' minutes</p>';
            echo '<p><strong>Servings:</strong> ' . htmlspecialchars($row['servings']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No recipes found for the provided ingredients.</p>';
    }
    
    $stmt->close();
}

$conn->close();
?>
