<?php
session_start();
require_once '../db/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email1']);
    $password = $_POST['register-password'];

    // Fixed variable names in empty check
    if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required."
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid email format."
        ]);
        exit;
    }

    try {
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Email address is already registered."
            ]);
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = $createdAt;
        $role = 2; // Regular admin
        $stmt = $connection->prepare("INSERT INTO users (fname, lname, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $fname, $lname, $email, $hashedPassword, $role, $createdAt, $updatedAt);
        
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Registration successful! Please log in."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Registration failed. Please try again."
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    } finally {
        $stmt->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}

$connection->close();
