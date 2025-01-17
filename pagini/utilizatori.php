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
    die("Error: Unable to connect to MySQL.");
}

// Handle Create
if (isset($_POST['create'])) {
    $nume = mysqli_real_escape_string($link, $_POST['nume_utilizator']);
    $verificat = mysqli_real_escape_string($link, $_POST['verificat']);
    $rol = mysqli_real_escape_string($link, $_POST['rol']);
    
    $query = "INSERT INTO utilizatori (nume_utilizator, verificat, rol) VALUES ('$nume', '$verificat', '$rol')";
    mysqli_query($link, $query);
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']); // Protecție împotriva SQL Injection
    $query = "DELETE FROM utilizatori WHERE id = $id";
    
    if (mysqli_query($link, $query)) {
        $_SESSION['success_message'] = "Utilizatorul a fost șters cu succes!";
    } else {
        $_SESSION['error_message'] = "Eroare la ștergere!";
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

$result = mysqli_query($link, "SELECT * FROM utilizatori");
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Dezvoltare Aplicații ManolovSky</title>
    <meta name="keywords" content="ManolovSky, aplicații mobile, cumpără aplicații, dezvoltare aplicații, app development, android, ios, web, programare">
    <meta name="description" content="Crează-ți propria aplicație pentru a crește vizibilitatea companiei tale. ManolovSky te ajută să realizezi o nouă aplicație sau să-ți transformi website-ul într-o aplicație pentru mobil.">
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <script type="text/javascript" src="/resurse/js/produse.js"></script>
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
    <style>
        .auth-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .form-container {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Ești sigur că vrei să ștergi această înregistrare?")) {
                document.getElementById('deleteForm' + id).submit();
            }
        }
    </script>
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Gestionare Utilizatori</h1>

            <!-- Mesaje de confirmare -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success_message']; ?></div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error_message']; ?></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <!-- Tabel utilizatori -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nume utilizator</th>
                        <th>Verificat</th>
                        <th>Rol</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nume_utilizator']) ?></td>
                            <td><?= $row['verificat'] == 1 ? 'Da' : 'Nu'; ?></td>
                            <td><?= htmlspecialchars($row['rol']) ?></td>
                            <td>
                                <form id="deleteForm<?= $row['id'] ?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="button" onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-danger">Șterge</button>
                                    <input type="hidden" name="delete">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
