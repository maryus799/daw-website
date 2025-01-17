<?php
session_start();
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$error_message = "";

// Verificăm dacă utilizatorul este într-o sesiune
if (!isset($_SESSION['username'])) {
    header("Location:../pagini/inregistrare.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['verify'])) {
    $entered_code = mysqli_real_escape_string($link, $_POST['verification_code']);

    // Verificăm codul de verificare din baza de date
    $result = mysqli_query($link, "SELECT cod_verificare FROM utilizatori WHERE nume_utilizator='$username' AND verificat=0");
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $actual_code = $row['cod_verificare'];

        if ($entered_code == $actual_code) {
            // Actualizăm utilizatorul ca verificat
            $update_query = "UPDATE utilizatori SET verificat=1 WHERE nume_utilizator='$username'";
            if (mysqli_query($link, $update_query)) {
                // Redirect către pagina admin
                unset($_SESSION['username']);
                header("Location: ../pagini/admin.php");
                exit;
            } else {
                $error_message = "A apărut o eroare la actualizarea contului. Te rugăm să încerci din nou.";
            }
        } else {
            $error_message = "Cod de verificare incorect. Te rugăm să încerci din nou.";
        }
    } else {
        $error_message = "Nu s-a găsit un cont care necesită verificare pentru acest utilizator.";
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Verificare cont</title>
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="fixed-background">
    <div class="container mt-5">
        <h1 class="text-center" style="color: orange;">Verificare cont</h1>
        <p class="text-center">Introdu codul de verificare primit pe email pentru utilizatorul: <strong><?php echo htmlspecialchars($username); ?></strong></p>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="verification_code" class="form-label" style="color: orange;">Cod de verificare:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" name="verify" class="btn btn-primary w-100">Verifică</button>
        </form>
        <?php if ($error_message) { echo "<p class='text-danger mt-3'>$error_message</p>"; } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
