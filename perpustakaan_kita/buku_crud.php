<?php
require "../config.php";
$conn = db_connect();



if (isset($_POST['tambah'])) {
    $idkategori = $_POST['idkategori'];
    $judul = $_POST['judul'];
    $gambar = $_FILES['gambar']['name'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Explicitly set the timezone to Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Get the current timestamp in Jakarta timezone
    $currentDateTime = date('Y-m-d H:i:s');

    // Check if the book with the same title already exists
    $existingBookQuery = "SELECT f_id FROM t_buku WHERE f_judul = '$judul'";
    $existingBookResult = $conn->query($existingBookQuery);

    if ($existingBookResult->num_rows > 0) {
        // Book with the same title exists, get its ID
        $existingBook = $existingBookResult->fetch_assoc();
        $existingBookId = $existingBook['f_id'];

        // Update updated_at in t_buku table
        $updateBookQuery = "UPDATE t_buku SET updated_at = '$currentDateTime' WHERE f_id = '$existingBookId'";
        $conn->query($updateBookQuery);

        // Insert data into t_detailbuku table based on the stock quantity
        for ($i = 0; $i < $stok; $i++) {
            $sql = "INSERT INTO t_detailbuku (f_idbuku, f_status, created_at) VALUES ('$existingBookId', 'Tersedia','$currentDateTime')";
            $conn->query($sql);

            echo "<script>alert('Stok Berhasil Ditambah!'); window.location.href = 'buku.php';</script>";
            exit();
        }
    } else {
        // Book with the same title doesn't exist, insert a new book into t_buku
        $sqlInsertBook = "INSERT INTO t_buku (f_idkategori, f_judul, f_gambar, f_pengarang, f_penerbit, f_deskripsi, created_at, updated_at) 
            VALUES ('$idkategori', '$judul', '$gambar', '$pengarang', '$penerbit', '$deskripsi', '$currentDateTime', '$currentDateTime')";
        $conn->query($sqlInsertBook);

        // Get the last inserted book ID
        $lastBookId = $conn->insert_id;

        // Insert data into t_detailbuku table based on the stock quantity
        for ($i = 0; $i < $stok; $i++) {
            $sql = "INSERT INTO t_detailbuku (f_idbuku, f_status, created_at) VALUES ('$lastBookId', 'Tersedia','$currentDateTime')";
            $conn->query($sql);
        }
        echo "<script>alert('Buku Berhasil Ditambah!'); window.location.href = 'buku.php';</script>";
        exit();
    }

    // Redirect to the book list page or display a success message
    header("Location: buku.php"); // Adjust with the actual file that displays the book list
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form is submitted for book update
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $idkategori = $_POST['idkategori'];
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        $deskripsi = $_POST['deskripsi'];

        // Explicitly set the timezone to Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Get the current timestamp in Jakarta timezone
        $currentDateTime = date('Y-m-d H:i:s');

        // Check if the new title is already used by other books
        $checkTitleSql = "SELECT COUNT(*) AS count FROM t_buku WHERE f_judul = '$judul' AND f_id <> $id";
        $result = $conn->query($checkTitleSql);

        if ($result) {
            $row = $result->fetch_assoc();
            $titleCount = $row['count'];

            // If the title is already used, show an alert
            if ($titleCount > 0) {
                echo "<script>alert('Judul buku sudah digunakan oleh data lain.'); window.location.href = 'buku.php';</script>";
                exit();
            }
        }

        // Check if a new image file is provided
        if ($_FILES['gambar']['name'] != "") {
            // Upload new image file
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

            // Update book data with new image file
            $sql = "UPDATE t_buku SET f_idkategori = '$idkategori', f_judul = '$judul', f_gambar = '" . basename($_FILES["gambar"]["name"]) . "', f_pengarang = '$pengarang', f_penerbit = '$penerbit', f_deskripsi = '$deskripsi', updated_at = '$currentDateTime' WHERE f_id = $id";
        } else {
            // Update book data without changing the image file
            $sql = "UPDATE t_buku SET f_idkategori = '$idkategori', f_judul = '$judul', f_pengarang = '$pengarang', f_penerbit = '$penerbit', f_deskripsi = '$deskripsi', updated_at = '$currentDateTime' WHERE f_id = $id";
        }

        // Execute SQL query
        $conn->query($sql);

        echo "<script>alert('Data Berhasil diubah!'); window.location.href = 'buku.php';</script>";
        exit();
    }
}





if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapusid"])) {
    $id = $_POST["hapusid"];

    // Query untuk mengecek apakah data masih digunakan oleh tabel lain
    $sqlCheckUsage = "SELECT COUNT(*) as count FROM t_detailbuku WHERE f_idbuku = $id";
    $result = $conn->query($sqlCheckUsage);

    if ($result) {
        $row = $result->fetch_assoc();
        $usageCount = $row['count'];

        // Jika data masih digunakan oleh tabel lain, tampilkan alert
        if ($usageCount > 0) {
            echo "<script>alert('Data tidak dapat dihapus karena masih digunakan oleh tabel lain.');";
            echo "window.location.href = 'buku.php';</script>";
            exit();
        }
    }

    // Jika data tidak digunakan oleh tabel lain, lanjutkan dengan menghapus data
    $sqlDeleteBuku = "DELETE FROM t_buku WHERE f_id = $id";

    if ($conn->query($sqlDeleteBuku) === TRUE) {
        echo "<script>alert('Data Berhasil dihapus!'); window.location.href = 'buku.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }

    exit();
}





// Replace this with your logic to fetch book details based on the bookId
$bookId = $_POST['bookId'];

// Sample query to fetch book details from the database
$query = "SELECT f_judul, f_gambar, f_pengarang, f_penerbit, f_deskripsi,created_at, updated_at FROM t_buku WHERE f_id = $bookId";
$result = $conn->query($query);

if ($result) {
    $bookDetails = $result->fetch_assoc();

    // Return book details as JSON
    echo json_encode($bookDetails);
} else {
    // Handle error if needed
    echo json_encode(['error' => 'Failed to fetch book details']);
}

$conn->close();
?>
