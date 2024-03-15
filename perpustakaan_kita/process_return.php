<?php
require "../config.php";
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $detailId = $_POST["detailId"];

    // Set the timezone to Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');
    // Get the current date and time
    $currentDateTime = date("Y-m-d H:i:s");

    // Update t_detailpeminjaman to set f_tanggalkembali to the current date and time
    $sqlUpdateReturn = "UPDATE t_detailpeminjaman SET f_tanggalkembali = '$currentDateTime' WHERE f_id = $detailId";
    $conn->query($sqlUpdateReturn);

    // Get the book ID from t_detailpeminjaman
    $sqlGetBookId = "SELECT f_iddetailbuku FROM t_detailpeminjaman WHERE f_id = $detailId";
    $result = $conn->query($sqlGetBookId);
    $row = $result->fetch_assoc();
    $bookId = $row["f_iddetailbuku"];

    // Update t_detailbuku to set f_status to 'Tersedia'
    $sqlUpdateBookStatus = "UPDATE t_detailbuku SET f_status = 'Tersedia' WHERE f_id = $bookId";
    $conn->query($sqlUpdateBookStatus);

    echo "success";
} else {
    echo "Invalid request";
}

$conn->close();
?>
