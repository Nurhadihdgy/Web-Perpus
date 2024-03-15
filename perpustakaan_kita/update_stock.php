<?php
require "../config.php";
$conn = db_connect();

if (isset($_GET['updatestock'])) {
    $updatestock = $_GET['updatestock'];
    $idbuku = $_GET['idbuku'];

    switch ($updatestock) {
        case 'kurang':
            // Check if the stock is already 1 or less
            $currentStock = $conn->query("SELECT COUNT(*) as jumlah FROM t_detailbuku WHERE f_status='Tersedia' AND f_idbuku = " . $idbuku)->fetch_assoc()['jumlah'];
            if ($currentStock > 0) {
                $sql = "SELECT DISTINCT f_id FROM t_detailbuku WHERE f_status='Tersedia' AND f_idbuku=" . $idbuku . " ORDER BY f_id DESC LIMIT 1";
                $result = $conn->query($sql);

                // Check if there are rows returned
                if ($result->num_rows > 0) {
                    $idDihapus = $result->fetch_assoc();
                    $idDihapus = $idDihapus['f_id'];
                    $sql = "DELETE FROM t_detailbuku WHERE f_id=" . $idDihapus;
                    $conn->query($sql);
                } else {
                    echo "No rows found for deletion.";
                }
            } else {
                echo "Stock cannot be less than 1.";
            }
            break;
        case 'tambah':
            $sql = "INSERT INTO t_detailbuku VALUES (NULL, " . $idbuku . ",'Tersedia')";
            $conn->query($sql);
            break;
        default:
            echo 'Invalid update type';
            break;
    }
    
    // Redirect back to buku.php
    header("Location: buku.php");
    exit();
} else {
    echo 'Update type not provided';
}
?>
