<?php
function db_connect() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "perpustakaan";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    return $conn;
}
?>