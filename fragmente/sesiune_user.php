<?php
session_start(); // Inițializează sesiunea

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['username'])) {
    header("Location:../pagini/login.php");
    exit;
}

// Conectare la baza de date
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

// Obține rolul utilizatorului din baza de date
$username = $_SESSION['username'];
$query = "SELECT rol FROM utilizatori WHERE nume_utilizator = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Verifică dacă utilizatorul nu este administrator
if ($user['rol'] !== 'utilizator') {
    header("Location: ../pagini/login.php"); // Redirecționează către o pagină de acces interzis
    exit;
}
?>