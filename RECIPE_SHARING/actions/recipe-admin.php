<?php
// Ensure the session is started
session_start();

// Include the database connection
include '../db/db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if action is specified
    if (!isset($_POST['action'])) {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
        exit;
    }

    // Check user authentication
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }

    try {
        switch ($_POST['action']) {
            case 'create':
                createRecipe($connection);
                break;
            case 'update':
                updateRecipe($connection);
                break;
            case 'delete':
                deleteRecipe($connection);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                exit;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred']);
        exit;
    }
}

// Function to create a new recipe
function createRecipe($connection)
{
    // Validate required fields
    $required = ['name', 'category', 'description', 'cook_time', 'difficulty'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Validate difficulty
    $validDifficulties = ['Easy', 'Medium', 'Hard'];
    if (!in_array(strtolower($_POST['difficulty']), $validDifficulties)) {
        echo json_encode(['success' => false, 'message' => 'Invalid difficulty level']);
        exit;
    }

    // Set optional fields with default values
    $image = isset($_POST['image']) ? $_POST['image'] : null;
    $created_at = date('Y-m-d H:i:s');

    // Prepare SQL statement to insert new recipe
    $stmt = $connection->prepare(
        "INSERT INTO recipes (name, category, description, cook_time, difficulty, image, created_at, created_by) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param(
        "sssssssi",
        $_POST['name'],
        $_POST['category'],
        $_POST['description'],
        $_POST['cook_time'],
        $_POST['difficulty'],
        $image,
        $created_at,
        $_SESSION['user_id']
    );

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $recipeId = $stmt->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Recipe created successfully',
        'recipe_id' => $recipeId
    ]);
}


// Function to update a recipe
function updateRecipe($connection)
{
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
        exit;
    }

    // Validate difficulty if provided
    if (isset($_POST['difficulty'])) {
        $validDifficulties = ['Easy', 'Medium', 'Hard'];
        if (!in_array(strtolower($_POST['difficulty']), $validDifficulties)) {
            echo json_encode(['success' => false, 'message' => 'Invalid difficulty level']);
            exit;
        }
    }

    // Verify user owns the recipe or has admin rights
    $stmt = $connection->prepare("SELECT created_by FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    if (!$recipe || ($recipe['created_by'] !== $_SESSION['user_id'] && !$_SESSION['is_admin'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    // Prepare SQL statement to update recipe
    $stmt = $connection->prepare(
        "UPDATE recipes 
         SET name = ?, category = ?, description = ?, cook_time = ?, difficulty = ? 
         WHERE id = ? AND created_by = ?"
    );

    $stmt->bind_param(
        "sssssii",
        $_POST['name'],
        $_POST['category'],
        $_POST['description'],
        $_POST['cook_time'],
        $_POST['difficulty'],
        $_POST['id'],
        $_SESSION['user_id']
    );

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();

    echo json_encode(['success' => true, 'message' => 'Recipe updated successfully']);
}

// Function to delete a recipe
function deleteRecipe($connection)
{
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
        exit;
    }

    // Verify user owns the recipe or has admin rights
    $stmt = $connection->prepare("SELECT created_by FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    if (!$recipe || ($recipe['created_by'] !== $_SESSION['user_id'] && !$_SESSION['is_admin'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    // Prepare SQL statement to delete the recipe
    $stmt = $connection->prepare("DELETE FROM recipes WHERE id = ? AND (created_by = ? OR ? = TRUE)");
    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    $stmt->bind_param("iii", $_POST['id'], $_SESSION['user_id'], $isAdmin);

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Recipe not found or unauthorized']);
        exit;
    }

    $stmt->close();

    echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully']);
}
?>