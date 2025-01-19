<?php include('../fragmente/sesiune_user.php'); ?>
<?php

// Preia datele utilizatorului din baza de date
$username = $_SESSION['username']; 
$query = "SELECT nume_utilizator, nume, prenume, adresa, rol, verificat, parola FROM utilizatori WHERE nume_utilizator = '$username'";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result); // Obține informațiile utilizatorului din baza de date

// Handle Update Profile - Actualizarea profilului utilizatorului
if (isset($_POST['update_profile'])) {
    // Preia valorile din formular
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $adresa = $_POST['adresa'];
    $rol = $_POST['rol'];
    $stare = $_POST['stare'];

    // Actualizează datele utilizatorului în baza de date
    $updateQuery = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', adresa = '$adresa', rol = '$rol', verificat = '$stare' WHERE nume_utilizator = '$username'";
    mysqli_query($link, $updateQuery);
    echo "<script>alert('Profilul a fost actualizat cu succes!');</script>";
}

// Handle Change Password - Schimbarea parolei utilizatorului
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password']; // Preia parola veche din formular
    $new_password = $_POST['new_password']; // Preia parola nouă din formular
    $confirm_password = $_POST['confirm_password']; // Preia confirmarea parolei noi

    // Verifică parola veche (fără hash)
    $checkPasswordQuery = "SELECT parola FROM utilizatori WHERE nume_utilizator = '$username'";
    $passwordResult = mysqli_query($link, $checkPasswordQuery);
    $userData = mysqli_fetch_assoc($passwordResult);

    // Compara parola veche cu parola din baza de date
    if ($old_password == $userData['parola']) {
        if ($new_password === $confirm_password) { // Verifică dacă parolele noi sunt identice
            // Actualizează parola în baza de date
            $updatePasswordQuery = "UPDATE utilizatori SET parola = '$new_password' WHERE nume_utilizator = '$username'";
            mysqli_query($link, $updatePasswordQuery);
            echo "<script>alert('Parola a fost schimbată cu succes!');</script>";
        } else {
            echo "<script>alert('Parolele noi nu corespund!');</script>"; // Mesaj de eroare dacă parolele nu corespund
        }
    } else {
        echo "<script>alert('Parola veche este incorectă!');</script>"; // Mesaj de eroare dacă parola veche este incorectă
    }
}

mysqli_close($link); // Închide conexiunea la baza de date
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profil Utilizator</title>
    <meta name="keywords" content="ManolovSky, profil utilizator, schimbare parola">
    <meta name="description" content="Pagina de profil pentru utilizatori">
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <script type="text/javascript" src="/resurse/js/produse.js"></script>
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        /* Culoarea textului pentru câmpul rol */
        #rol {
            color: blue; /* Textul câmpului rol va fi de culoare albastră */
        }

        /* Culoarea textului pentru câmpul verificat */
        #stare {
            font-weight: bold; /* Îngroșarea fontului pentru câmpul stare */
        }

        /* Culoarea verde pentru utilizatori verificați */
        .verificat {
            color: green; /* Textul va fi verde dacă utilizatorul este verificat */
        }

        /* Culoarea roșie pentru utilizatori neverificați */
        .nep_verificat {
            color: red; /* Textul va fi roșu dacă utilizatorul nu este verificat */
        }
    </style>
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_user.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Profil Utilizator</h1>

            <!-- Formular pentru actualizarea profilului utilizatorului -->
            <form method="POST">
                <div class="form-group">
                    <label for="nume_utilizator">Nume utilizator:</label>
                    <input type="text" class="form-control" id="nume_utilizator" value="<?= $user['nume_utilizator'] ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="nume">Nume:</label>
                    <input type="text" class="form-control" id="nume" name="nume" value="<?= $user['nume'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenume">Prenume:</label>
                    <input type="text" class="form-control" id="prenume" name="prenume" value="<?= $user['prenume'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="adresa">Adresă:</label>
                    <input type="text" class="form-control" id="adresa" name="adresa" value="<?= $user['adresa'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <input type="text" class="form-control" id="rol" name="rol" value="<?= $user['rol'] ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="stare">Stare:</label>
                    <input type="text" class="form-control" id="stare" value="<?= $user['verificat'] == 1 ? 'Verificat' : 'Nep verficat' ?>" disabled class="<?= $user['verificat'] == 1 ? 'verificat' : 'nep_verificat' ?>">
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary mt-3">Actualizează Profilul</button>
            </form>

            <!-- Formular pentru schimbarea parolei -->
            <hr>
            <h2>Schimbă Parola</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="old_password">Parola Veche:</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Parola Nouă:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirma Parola Nouă:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-success mt-3">Schimbă Parola</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
