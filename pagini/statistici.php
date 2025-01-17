<?php
session_start(); // Inițializează sesiunea

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['username'])) {
    header("Location:../pagini/login.php");
    exit;
}

$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");
mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

// Obține numărul total de vizualizări
$totalViewsQuery = "SELECT SUM(accesari) AS total FROM statistici";
$totalViewsResult = mysqli_query($link, $totalViewsQuery);
$totalViewsRow = mysqli_fetch_assoc($totalViewsResult);
$totalViews = $totalViewsRow['total'] ?? 0;

// Obține datele pentru histogramă
$statsQuery = "SELECT pagina, accesari FROM statistici ORDER BY accesari DESC";
$statsResult = mysqli_query($link, $statsQuery);

$pages = [];
$views = [];
while ($row = mysqli_fetch_assoc($statsResult)) {
    $pages[] = $row['pagina'];
    $views[] = $row['accesari'];
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistici Site</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Statistici Site</h1>
            <p>Total vizualizări: <strong><?= $totalViews ?></strong></p>
            <canvas id="statsChart"></canvas>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($pages) ?>,
                datasets: [{
                    label: 'Accesări',
                    data: <?= json_encode($views) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
