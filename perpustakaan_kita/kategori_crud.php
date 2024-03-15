<?php
require "../config.php";
$conn = db_connect();
 
// Process add category form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["kategori"])) {
    $kategori = $_POST["kategori"];

     // Explicitly set the timezone to Jakarta
     date_default_timezone_set('Asia/Jakarta');

     // Get the current timestamp in Jakarta timezone
     $currentDateTime = date('Y-m-d H:i:s');

   // Check if the category already exists
    $checkSql = "SELECT COUNT(*) as count FROM t_kategori WHERE f_kategori = '$kategori'";
    $result = $conn->query($checkSql);
    $row = $result->fetch_assoc();
    $categoryCount = $row['count'];

    if ($categoryCount > 0) {
        // Category already exists, show alert
        echo "<script>alert('Data sudah ada!'); window.location.href = 'kategori.php';</script>";
        exit();
    } else {
        // Category doesn't exist, proceed with adding
        $sqlAdd = "INSERT INTO t_kategori (f_kategori, created_at, updated_at) VALUES ('$kategori','$currentDateTime','$currentDateTime')";
        $conn->query($sqlAdd);
        echo "<script>alert('Data Berhasil di tambah!'); window.location.href = 'kategori.php';</script>";
        exit();
    }
}

// Process edit category form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["editkategori"])) {
    $categoryId = $_POST['id'];
$newCategory = $_POST['editkategori'];
 
// Explicitly set the timezone to Jakarta
date_default_timezone_set('Asia/Jakarta');

// Get the current timestamp in Jakarta timezone
$currentDateTime = date('Y-m-d H:i:s');
// Check if the updated category already exists
$checkSql = "SELECT COUNT(*) as count FROM t_kategori WHERE f_kategori = '$newCategory' AND f_id <> $categoryId";
$result = $conn->query($checkSql);
$row = $result->fetch_assoc();
$categoryCount = $row['count'];



if ($categoryCount > 0) {
    // Updated category already exists, show alert
    echo "<script>alert('Data yang Anda ubah sudah ada!'); window.location.href = 'kategori.php';</script>";
    exit();
} else {
    // Perform the update query
    $updateSql = "UPDATE t_kategori SET f_kategori = '$newCategory', updated_at = '$currentDateTime' WHERE f_id = $categoryId";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect back to the category page or handle the response accordingly
        echo "<script>alert('Data Berhasil di ubah!'); window.location.href = 'kategori.php';</script>";
        exit();
    } else {
        echo "Error updating category: " . $conn->error;
    }
}
}



// Process delete category form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapusid"])) {
    $id = $_POST["hapusid"];

    // Periksa apakah ada data terkait di t_buku
$sqlCheck = "SELECT COUNT(*) as count FROM t_buku WHERE f_idkategori = $id";
$resultCheck = $conn->query($sqlCheck);
$rowCheck = $resultCheck->fetch_assoc();

if ($rowCheck['count'] > 0) {
    echo "<script>alert('Data tidak dapat dihapus karena masih digunakan oleh buku'); window.location.href = 'kategori.php';</script>";
} else {
    // Lanjutkan dengan penghapusan
    $sqlDelete = "DELETE FROM t_kategori WHERE f_id=$id";
    $conn->query($sqlDelete);
    echo "<script>alert('Data Berhasil dihapus!'); window.location.href = 'kategori.php';</script>";
    exit();
}

}


?>