<?php
session_start(); // Mulai sesi

// Hapus semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header('Location: ../index.php');
?>
