<?php

require ('./config.php');
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
$sql = "SELECT * FROM t_admin WHERE f_username = '$username' AND f_password = '$hashedPassword'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Check if the user is active
    if ($row['f_status'] == 'Aktif') {
        // User found in the database
        $userId = $row['f_id'];  // Assuming 'id' is the user ID column in your database
        $username = $row['f_username'];
        $userLevel = $row['f_level'];
        $nama = $row['f_nama'];

        // Start a session and store user information
        session_start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['user_level'] = $userLevel;
        $_SESSION['user_nama'] = $nama;

        // Redirect based on user level
        if ($userLevel == 'Admin') {
            echo "<script>alert('Login successful! Redirecting to admin dashboard.'); window.location.href = './perpustakaan_kita/index.php';</script>";
        } elseif ($userLevel == 'Pustakawan') {
            echo "<script>alert('Login successful! Redirecting to pustakawan dashboard.'); window.location.href = './perpustakaan_kita/index.php';</script>";
        } else {
            // Handle other user levels or unexpected cases
            echo "<script>alert('Invalid user level.'); window.location.href = 'loginadmin.php';</script>";
        }
    } else {
        // User is not active
        echo "<script>alert('Account is not active.'); window.location.href = 'loginadmin.php';</script>";
    }
} else {
    // Username or password is incorrect
    echo "<script>alert('Invalid username or password.'); window.location.href = 'loginadmin.php';</script>";
}

$conn->close();
?>
