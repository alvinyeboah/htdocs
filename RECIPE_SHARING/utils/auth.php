<?php
session_start();
$userRole = $_SESSION['role'];

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_reason'] = "You need to be signed in to access this page.";
        header("Location: ../views/login.php");
        exit;
    }
}
