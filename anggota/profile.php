<?php
include "header.php";
require "../config.php";
$conn = db_connect();

// Ensure the user is logged in
if (!isset($_SESSION['f_username'])) {
    // Redirect to the login page or display an error message
    echo "<script>alert('Anda tidak memiliki akses.'); window.location.href = '../loginanggota.php';</script>";
    exit();
}

// Get user information from the session
$userNama = $_SESSION['f_username'];

// Fetch user profile from the database
$sql = "SELECT * FROM t_anggota WHERE f_username = '$userNama'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $profile = $result->fetch_assoc();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profil</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Display user profile information in a card -->
            <div class="card">
                <div class="card-header">
                    Profil <?php echo $userNama; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Nama: <?php echo $profile['f_nama']; ?></h5>
                    <p class="card-text">Username: <?php echo $profile['f_username']; ?></p>
                    <p class="card-text">Tempat Lahir: <?php echo $profile['f_tempatlahir']; ?></p>
                    <p class="card-text">Tanggal Lahir: <?php echo $profile['f_tanggallahir']; ?></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php 
} else {
    // Handle the case where user profile is not found
    echo "User profile not found!";
}

include "footer.php"; 
?>

