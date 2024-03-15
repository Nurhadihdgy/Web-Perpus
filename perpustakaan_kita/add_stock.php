<?php
require "../config.php";
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookId"]) && isset($_POST["stockQuantity"]) && isset($_POST["stockDate"])) {
    $bookId = $_POST["bookId"];
    $quantity = $_POST["stockQuantity"];
    $date = $_POST["stockDate"];

    // Explicitly set the timezone to Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Get the current timestamp in Jakarta timezone
    $currentDateTime = date('Y-m-d H:i:s');

    // Update updated_at in t_buku table
    $updateBookQuery = "UPDATE t_buku SET updated_at = '$currentDateTime' WHERE f_id = '$bookId'";
    $conn->query($updateBookQuery);


    // Insert data into t_detailbuku table based on the stock quantity
    for ($i = 0; $i < $quantity; $i++) {
        $sql = "INSERT INTO t_detailbuku (f_idbuku, f_status, created_at) VALUES ('$bookId', 'Tersedia', '$date')";
        $conn->query($sql);
    }

    echo "Stock added successfully!";
} else {
    echo "Invalid request!";
}
?>
