<?php
session_start();
include('../recaptcha/verify_recaptcha.php');
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$error_message = "";
$show_recaptcha = true; // Setăm ca reCAPTCHA să fie întotdeauna vizibil

if (isset($_POST['login'])) {
    // Verificăm dacă reCAPTCHA a fost bifat
    if (empty($_POST['g-recaptcha-response'])) {
        $error_message = "Te rugăm să bifezi reCAPTCHA.";
    } else {
        // Dacă reCAPTCHA a fost bifat, continuăm cu validarea userului și parolei
        $username = mysqli_real_escape_string($link, $_POST['username']);
        $password = mysqli_real_escape_string($link, $_POST['password']);

        // Verificăm dacă răspunsul la reCAPTCHA este valid
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $recaptcha_valid = verify_recaptcha($recaptcha_response); // Funcție definită în verify_recaptcha.php

        if (!$recaptcha_valid) {
            $error_message = "Verificarea reCAPTCHA a eșuat. Te rugăm să încerci din nou.";
        } else {
            $query = "SELECT * FROM utilizatori WHERE nume_utilizator='$username'";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);

                if ($password === $user['parola']) {
                    if ($user['verificat'] == 1) {
                        $_SESSION['username'] = $username;

                        // Verifică rolul utilizatorului
                        if ($user['rol'] == 'utilizator') {
                            header("Location: ../pagini/user.php");
                        } elseif ($user['rol'] == 'administrator') {
                            header("Location: ../pagini/admin.php");
                        } else {
                            $error_message = "Rolul utilizatorului nu este valid.";
                        }
                        exit;
                    } else {
                        $error_message = "Contul tău nu este verificat. Te rugăm să verifici emailul pentru a activa contul.";
                    }
                } else {
                    $error_message = "Nume de utilizator sau parolă incorecte.";
                }
            } else {
                $error_message = "Nume de utilizator sau parolă incorecte.";
            }
        }
    }
}
mysqli_close($link);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Autentificare</title>
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="fixed-background">
    <div class="container mt-5">
        <h1 class="text-center" style="color: orange;">Autentificare</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label" style="color: orange;">Nume de utilizator:</label>
                <input type="text" class="form-control" id="username" name="username"
                    <?= isset($_POST['login']) ? 'required' : '' ?>>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label" style="color: orange;">Parolă:</label>
                <input type="password" class="form-control" id="password" name="password"
                    <?= isset($_POST['login']) ? 'required' : '' ?>>
            </div>
            <?php if ($show_recaptcha): ?>
                <div class="g-recaptcha mb-3" data-sitekey="6LfZ9boqAAAAAIGMN4L0vXyOdQygUaQag7wQbQjd"></div>
            <?php endif; ?>
    </div>
    <div class="mb-3">
        <button type="submit" name="login" class="btn btn-success w-200 mt-2">Autentificare</button>
        <button type="button" class="btn btn-primary w-200 mt-2" onclick="window.location.href='./inregistrare.php'">Cont Nou</button>
        <button type="button" class="btn btn-secondary w-200 mt-2" onclick="window.location.href='../index.php'">Acasă</button>
    </div>

    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>