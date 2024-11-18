<?php
session_start();
require_once '../db/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = $_POST['remember_me'] ?? false;

    if (empty($email) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "Email and password are required."
        ]);
        exit;
    }
    try {
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                unset($_SESSION['redirect_reason']);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fname'] = $user['fname'];
                $_SESSION['lname'] = $user['lname'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['createdAt'] = $user['created_at'];
                $_SESSION['updatedAt'] = $user['updated_at'];

                echo json_encode([
                    "success" => true,
                    "message" => "Login successful!",
                    "redirect" => "../views/dashboard.php",
                    "user" => [
                        "id" => $user['user_id'],
                        "fname" => $user['fname'],
                        "lname" => $user['lname'],
                        "role" => $user['role'],
                        "email" => $user['email'],
                        "createdAt" => $user["created_at"],
                        "updatedAt" => $user["updated_at"],
                    ]
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid password."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No user found with that email."
            ]);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "An error occurred during login."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}

$connection->close();