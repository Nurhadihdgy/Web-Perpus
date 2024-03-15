<?php
require_once 'config.php';

// Establish database connection
$conn = db_connect();

// Function to sanitize user input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to hash the password using MD5
function hashPassword($password) {
    return md5($password);
}

// Get user input from the form
$username = sanitizeInput($_POST['username']);
$enteredPassword = sanitizeInput($_POST['password']);
$hashedPassword = hashPassword($enteredPassword); // Hash the entered password using MD5

// SQL query to check user credentials
$sql = "SELECT * FROM t_anggota WHERE f_username = '$username' AND f_password = '$hashedPassword'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found in the database

    $row = $result->fetch_assoc();
    $userId = $row['f_id'];
    $username = $row['f_username'];

    // Start a session and store user information
    session_start();
    $_SESSION['f_id'] = $userId;
    $_SESSION['f_username'] = $username;
    

    // Redirect to a member area or any other page
    header('Location: ./anggota/memberarea.php?login=success');
    exit;
} else {
    // Username or password is incorrect
    echo "<script>alert('Invalid username or password.'); window.location.href = 'loginanggota.php';</script>";
}

// Close the database connection
$conn->close();
?>
