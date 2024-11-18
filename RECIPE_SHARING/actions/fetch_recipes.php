<?php 

try {
    require_once '../db/db.php';
    
    // Check connection
    if ($connection->connect_error) {
        throw new Exception("Database connection failed: " . $connection->connect_error);
    }
    
    $query = "SELECT 
        id,
        name,
        description,
        image,
        category,
        difficulty,
        created_at,
        created_by
    FROM recipes";
    
    $result = $connection->query($query);
    
    if ($result === false) {
        throw new Exception("Query execution failed: " . $connection->error);
    }
    
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = [
            'id' => (int)$row['id'],
            'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'),
            'image' => htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'),
            'category' => htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'),
            'difficulty' => htmlspecialchars($row['difficulty'], ENT_QUOTES, 'UTF-8'),
            'created_at' => $row['created_at'],
            'created_by' => (int)$row['created_by']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $recipes
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    error_log($e->getMessage()); // Log the actual error
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred while fetching recipes',
        'debug_message' => $e->getMessage() // Include actual error for debugging
    ], JSON_PRETTY_PRINT);
}