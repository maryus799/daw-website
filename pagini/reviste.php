<?php
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");


if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$result = mysqli_query($link, "SELECT * FROM reviste");
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reviste</title>
    <meta name="keywords"
        content="Reviste, aplicații educative, bibliotecă digitală">
    <meta name="description"
        content="Explorează revistele educative disponibile în biblioteca digitală.">
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
</head>
<body class="fixed-background">
    <?php include('../fragmente/header.php'); ?>
    <main>
    <div class="container mt-5">
        <h1>Reviste Disponibile</h1>
        <h2 style="color:white;">Pentru a accesa revistele disponibile trebuie creat un nou cont in sectiunea ”Contul Meu”  </h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titlu</th>
                    <th>Descriere</th>
                    <th>Categorie</th>
                    <th>Vârstă</th>
                    <th>Autor</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['titlu'] ?></td>
                    <td><?= $row['descriere_scurta'] ?></td>
                    <td><?= $row['categorie'] ?></td>
                    <td><?= $row['varsta'] ?></td>
                    <td><?= $row['autor'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
