<?php
require "../config.php";
$conn = db_connect();

function isUsernameAvailable($username, $currentUserId = null) {
    global $conn;

    $sqlAnggota = "SELECT f_username FROM t_anggota WHERE f_username = '$username'";
    if (!is_null($currentUserId)) {
        $sqlAnggota .= " AND f_id <> $currentUserId";
    }
    $resultAnggota = $conn->query($sqlAnggota);

    $sqlAdmin = "SELECT f_username FROM t_admin WHERE f_username = '$username'";
    if (!is_null($currentUserId)) {
        $sqlAdmin .= " AND f_id <> $currentUserId";
    }
    $resultAdmin = $conn->query($sqlAdmin);

    return ($resultAnggota->num_rows === 0) && ($resultAdmin->num_rows === 0);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama']) && isset($_POST['username']) && isset($_POST['level']) && isset($_POST['status'])) {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $level = $_POST['level'];
        $status = $_POST['status'];

        // Check if the password is not empty
        if (!empty($_POST['password'])) {
            // Hash the password using MD5
            $password = md5($_POST['password']);
        } else {
            // If password is empty, set it to NULL in the SQL query
            $password = NULL;
        }

        // Explicitly set the timezone to Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Get the current timestamp in Jakarta timezone
        $currentDateTime = date('Y-m-d H:i:s');

        if (isset($_POST['id'])) {
            // Update existing admin
            $id = $_POST['id'];

            // Check if the username is available excluding the current admin
            if (!isUsernameAvailable($username, $id)) {
                echo "<script>alert('Username sudah digunakan oleh user lain.'); window.location.href = 'admin.php';</script>";
                exit();
            }

            $sql = "UPDATE t_admin SET f_nama='$nama', f_username='$username',";

            // Include password in the query only if it's not empty
            if (!is_null($password)) {
                $sql .= "f_password='$password',";
            }

            $sql .= "f_level='$level', f_status='$status', updated_at ='$currentDateTime' WHERE f_id=$id";

            $operation = "di update";
        } else {
            // Check if the username is available
            if (!isUsernameAvailable($username)) {
                echo "<script>alert('Username tidak tersedia.'); window.location.href = 'admin.php';</script>";
                exit();
            }

            // Insert new admin
            $sql = "INSERT INTO t_admin (f_nama, f_username, ";

            // Include password in the query only if it's not empty
            if (!is_null($password)) {
                $sql .= "f_password, ";
            }

            $sql .= "f_level, f_status,created_at, updated_at) VALUES ('$nama', '$username', ";

            // Include password in the query only if it's not empty
            if (!is_null($password)) {
                $sql .= "'$password', ";
            }

            $sql .= "'$level', '$status','$currentDateTime','$currentDateTime')";

            $operation = "di tambah";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data berhasil $operation.'); window.location.href = 'admin.php';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['id'])) {
        // Delete admin
        $id = $_POST['id'];

// Query untuk mengecek apakah data masih digunakan oleh tabel lain
$sqlCheckUsage = "SELECT COUNT(*) as count FROM t_peminjaman WHERE f_idadmin = $id"; // Ganti "tabel_lain" dan "f_id_anggota" sesuai dengan tabel dan kolom yang sesuai
$result = $conn->query($sqlCheckUsage);

if ($result) {
    $row = $result->fetch_assoc();
    $usageCount = $row['count'];

    // Jika data masih digunakan oleh tabel lain, tampilkan alert
    if ($usageCount > 0) {
        echo "<script>alert('Data tidak dapat dihapus karena masih digunakan oleh tabel lain.');";
        echo "window.location.href = 'admin.php';</script>";
        exit();
    }
}

// Jika data tidak digunakan oleh tabel lain, lanjutkan dengan menghapus data
$sql = "DELETE FROM t_admin WHERE f_id=$id";
$operation = "di hapus";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil $operation.'); window.location.href = 'admin.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}
    }
}

$conn->close();
?>
