<?php
session_start();

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Conectează-te la baza de date pentru a verifica rolul utilizatorului
    $link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

    mysqli_set_charset($link, "utf8mb4");

    if (!$link) {
        echo "Error: Unable to connect to MySQL.";
        exit;
    }

    // Obține rolul utilizatorului din baza de date
    $query = "SELECT rol FROM utilizatori WHERE nume_utilizator='$username'";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $user_role = $user['rol'];
    } else {
        // Dacă nu se găsește utilizatorul în baza de date, distruge sesiunea
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    mysqli_close($link);

    // Verifică ce acțiune a ales utilizatorul
    if (isset($_POST['confirm_logout'])) {
        // Dacă utilizatorul confirmă delogarea
        session_destroy(); // Șterge toate datele sesiunii
        header("Location:../index.php"); // Redirecționează la pagina de login
        exit;
    } elseif (isset($_POST['cancel_logout'])) {
        // Dacă utilizatorul anulează delogarea, redirecționează în funcție de rol
        if ($user_role == 'administrator') {
            header("Location:../pagini/admin.php"); // Redirecționează la dashboard-ul administratorului
        } elseif ($user_role == 'utilizator') {
            header("Location:../pagini/user.php"); // Redirecționează la pagina utilizatorului
        } else {
            // Dacă rolul nu este definit corect, distruge sesiunea
            session_destroy();
            header("Location: ../index.php");
        }
        exit;
    }
} else {
    // Dacă sesiunea nu este validă, redirecționează la pagina de login
    header("Location: ../index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delogare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4" style="color: orange;">Sigur vrei să te deloghezi?</h1>
        <form method="POST">
            <button type="submit" name="confirm_logout" class="btn btn-danger me-3">Da, deloghează-mă</button>
            <button type="submit" name="cancel_logout" class="btn btn-secondary">Nu, anulează</button>
        </form>
    </div>
</body>

</html>