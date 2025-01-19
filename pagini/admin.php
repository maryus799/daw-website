<?php include('../fragmente/sesiune_admin.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_form'])) {
    $_SESSION['form_state'] = 'visible';
    unset($_SESSION['edit_data']); // Resetează datele de editare
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?')); // Elimină parametrii din URL
    exit;
}

// Inițializează starea formularului editabil 
if (!isset($_SESSION['form_state'])) {
    $_SESSION['form_state'] = 'hidden'; // Ascunde formularul la început
}

// Resetăm formularul atunci când se apasă pe "Adaugă revistă nouă"
if (isset($_POST['toggle_form'])) {

    // Verifică dacă formularul este ascuns și schimbă starea
    if ($_SESSION['form_state'] === 'hidden') {
        $_SESSION['form_state'] = 'visible';  // Face formularul vizibil
        // Resetează orice date de editare
        unset($_SESSION['edit_data']);
    }
}

// Dacă se apasă pe butonul de editare, salvează datele
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']); // Convertim în întreg pentru a evita injecția
    $stmt = $link->prepare("SELECT * FROM reviste WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $editRow = $stmt->get_result()->fetch_assoc();

    // Salvează datele revistei pentru a le prepopula în formular
    $_SESSION['edit_data'] = $editRow;

    // Schimbă starea formularului pentru editare
    $_SESSION['form_state'] = 'visible';
    $stmt->close();
} else {
    // Dacă nu se editează, resetăm datele de editare
    unset($_SESSION['edit_data']);
}

// Creare Revista Nouă
if (isset($_POST['create'])) {
    $titlu = $_POST['titlu'];
    $imagine = "../resurse/imagini/reviste/jocuri.jpg"; 
    $descriere = $_POST['descriere'];
    $categorie = $_POST['categorie'];
    $varsta = intval($_POST['varsta']);
    $autor = $_POST['autor'];
    $id_utilizator = 1; // Exemplu pentru id_utilizator

    // Verifică dacă revista există deja
    $stmt = $link->prepare("SELECT * FROM reviste WHERE titlu = ?");
    $stmt->bind_param("s", $titlu);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Revista există deja!');</script>";
    } else {
        $stmt = $link->prepare("INSERT INTO reviste (titlu, imagine, descriere_scurta, categorie, varsta, autor, id_utilizator) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisi", $titlu, $imagine, $descriere, $categorie, $varsta, $autor, $id_utilizator);
        $stmt->execute();
        echo "<script>document.getElementById('form-container').scrollIntoView({ behavior: 'smooth' });</script>";
        $stmt->close();
    }
}

// Actualizează revista existentă
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $titlu = $_POST['titlu'];
    $descriere = $_POST['descriere'];
    $categorie = $_POST['categorie'];
    $varsta = intval($_POST['varsta']);
    $autor = $_POST['autor'];

    $stmt = $link->prepare("UPDATE reviste SET titlu = ?, descriere_scurta = ?, categorie = ?, varsta = ?, autor = ? WHERE id = ?");
    $stmt->bind_param("sssisi", $titlu, $descriere, $categorie, $varsta, $autor, $id);
    $stmt->execute();
    $stmt->close();
}

// Șterge revista
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);

    $stmt = $link->prepare("DELETE FROM reviste WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Setează formularul ca ascuns după ștergere
    $_SESSION['form_state'] = 'hidden';

    // Resetează URL-ul pentru a elimina parametrii din query string
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$result = $link->query("SELECT * FROM reviste");
$link->close();
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
    <style>
        .auth-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .form-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container.hidden {
            display: none;
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
        function cancelForm() {
            var formContainer = document.getElementById("form-container");
            if (formContainer) {
                formContainer.classList.add("hidden");
            }
        }

        function confirmDelete() {
            return confirm("Ești sigur că vrei să ștergi această înregistrare?");
        }

        document.addEventListener("DOMContentLoaded", function() {
            var formContainer = document.getElementById("form-container");
            if (formContainer && !formContainer.classList.contains("hidden")) {
                formContainer.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });
    </script>
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Gestionare Reviste</h1>

            <form method="POST" style="display: inline;">
                <button class="btn btn-success mb-3" type="submit" name="toggle_form">
                    Adaugă revistă nouă
                </button>
            </form>

            <!-- Afișare tabel -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titlu</th>
                        <th>Imagine</th>
                        <th>Descriere</th>
                        <th>Categorie</th>
                        <th>Vârstă</th>
                        <th>Autor</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><a href="revista.php?id=<?= $row['id'] ?>" class="text-decoration-none"><?= $row['titlu'] ?></a></td>
                            <td><img src="/uploads/<?= $row['imagine'] ?>" alt="Imagine" width="50"></td>
                            <td><?= $row['descriere_scurta'] ?></td>
                            <td><?= $row['categorie'] ?></td>
                            <td><?= $row['varsta'] ?></td>
                            <td><?= $row['autor'] ?></td>
                            <td>
                                <a href="?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editează</a>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Șterge</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Formular pentru Crează/Update -->
            <div id="form-container" class="form-container <?php echo isset($_SESSION['form_state']) && $_SESSION['form_state'] === 'hidden' ? 'hidden' : ''; ?>">

                <form method="POST">
                    <input type="hidden" name="id" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['id'] : '' ?>">

                    <label for="titlu">Titlu:</label>
                    <input type="text" class="form-control-left" id="titlu" name="titlu" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['titlu'] : '' ?>" required>

                    <label for="descriere">Descriere:</label>
                    <input type="text" class="form-control" id="descriere" name="descriere" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['descriere_scurta'] : '' ?>" required>

                    <label for="categorie">Categorie:</label>
                    <input type="text" class="form-control" id="categorie" name="categorie" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['categorie'] : '' ?>" required>

                    <label for="varsta">Vârstă:</label>
                    <input type="number" class="form-control" id="varsta" name="varsta" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['varsta'] : '' ?>" required>

                    <label for="autor">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="<?= isset($_SESSION['edit_data']) ? $_SESSION['edit_data']['autor'] : '' ?>" required>

                    <div class="mt-3" id="form-buttons">
                        <?php if (isset($_SESSION['edit_data'])) { ?>
                            <button type="submit" name="update" class="btn btn-success">Actualizează</button>
                        <?php } else { ?>
                            <button type="submit" name="create" class="btn btn-success">Adaugă</button>
                        <?php } ?>
                        <button type="button" class="btn btn-secondary" onclick="cancelForm()">Renunță</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
