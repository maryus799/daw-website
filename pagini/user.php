<?php include('../fragmente/sesiune_user.php'); ?>
<?php
$result = mysqli_query($link, "SELECT * FROM reviste");
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dezvoltare Aplicații ManolovSky</title>
    <meta name="keywords" content="ManolovSky, aplicații mobile, cumpără aplicații, dezvoltare aplicații, app development, android, ios, web, programare">
    <meta name="description" content="Crează-ți propria aplicație pentru a crește vizibilitatea companiei tale. ManolovSky te ajută să realizezi o nouă aplicație sau să-ți transformi website-ul într-o aplicație pentru mobil.">
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_user.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Reviste</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titlu</th>
                        <th>Descriere</th>
                        <th>Categorie</th>
                        <th>Vârstă</th>
                        <th>Autor</th>
                        <th>Acțiuni</th>
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
                            <td>
                                <a href="generare_prefata.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Prefață</a>
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
