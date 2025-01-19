<?php include('../fragmente/sesiune_admin.php'); ?>
<?php
// Obținerea datelor din baza de date
$query = "SELECT pagina, vizualizari, accesari FROM statistici ORDER BY id ASC";
$result = mysqli_query($link, $query);

$pages = [];
$views = [];
$accesses = [];

while ($row = mysqli_fetch_assoc($result)) {
    $pages[] = $row['pagina'];
    $views[] = (int)$row['vizualizari'];
    $accesses[] = (int)$row['accesari'];
}

mysqli_close($link);

require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_line.php');
require_once('../jpgraph/src/jpgraph_pie.php');
require_once('../jpgraph/src/jpgraph_pie3d.php');


// Verificăm dacă există date pentru grafic
if (empty($views) || empty($pages) || empty($accesses)) {
    die("Nu există date suficiente pentru a genera graficul.");
}

// Crearea graficului
$graph = new Graph(700, 400);
$graph->SetScale("textlin");

$graph->SetMargin(50, 20, 40, 80);

$graph->xaxis->SetTickLabels($pages);
$graph->xaxis->SetTitle("Pagini", 'center');
$graph->yaxis->SetTitle("Număr Vizualizări / Accesări");

// Linie pentru vizualizări
$p1 = new LinePlot($views);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Vizualizări');

// Linie pentru accesări
$p2 = new LinePlot($accesses);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Accesări');

$graph->legend->SetFrameWeight(1);


// Salvarea graficului într-un fișier PNG
$graphFile = '../resurse/imagini/lie_site.png'  . time();;
$graph->Stroke($graphFile);


// Crearea graficului Pie
$graph2 = new PieGraph(700, 400);

$theme_class = new VividTheme();
$graph2->SetTheme($theme_class);

// Setarea titlului graficului
$graph2->title->Set("Vizualizări");

// Crearea graficului Pie 3D
$p1 = new PiePlot3D($views);
$graph2->Add($p1);

$p1->SetLegends($pages); // Adăugarea paginilor în legendă
$p1->SetLabelType(PIE_VALUE_PER); // Afișare procente
$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1); // Evidențierea primului slice



// Salvarea graficului într-un fișier PNG
$graphFile2 = '../resurse/imagini/pie_site.png' . time();
$graph2->Stroke($graphFile2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistici Site</title>
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Statistici Site</h1>
            <div>
            <img src="<?php echo $graphFile; ?>" alt="Grafic Statistici Site" class="img-fluid" />
<div></div>
<img src="<?php echo $graphFile2; ?>" alt="Grafic Statistici Site" class="img-fluid" />
            </div>
        </div>
    </main>
</body>
</html>