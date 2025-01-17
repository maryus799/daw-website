<?php
session_start();

// Conectare la baza de date
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['username'])) {
    header("Location:../pagini/login.php");
    exit;
}

// Obține ID-ul revistei din parametrii URL-ului
if (!isset($_GET['id'])) {
    echo "ID-ul revistei nu a fost specificat.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM reviste WHERE id = $id";
$result = mysqli_query($link, $query);
$revista = mysqli_fetch_assoc($result);

if (!$revista) {
    echo "Revista nu a fost găsită.";
    exit;
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta name="keywords" content="ManolovSky, aplicații mobile, cumpără aplicații, dezvoltare aplicații, app development, android, ios, web, programare">
    <meta name="description" content="Crează-ți propria aplicație pentru a crește vizibilitatea companiei tale. ManolovSky te ajută să realizezi o nouă aplicație sau să-ți transformi website-ul într-o aplicație pentru mobil.">
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
    <style>
        .revista-container {
            text-align: center;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .revista-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .revista-container h1 {
            margin-top: 10px;
        }
    </style>
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        
    <div class="revista-container">
        <img src="<?php echo htmlspecialchars($revista['imagine']); ?>" alt="<?php echo htmlspecialchars($revista['titlu']); ?>">
        <h1><?php echo htmlspecialchars($revista['titlu']); ?></h1>
        <p><strong>Descriere:</strong> <?php echo htmlspecialchars($revista['descriere_scurta']); ?></p>
        <p><strong>Categorie:</strong> <?php echo htmlspecialchars($revista['categorie']); ?></p>
        <p><strong>Vârstă recomandată:</strong> <?php echo intval($revista['varsta']); ?></p>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($revista['autor']); ?></p>
    </div>
    </main>
</body>

</html>