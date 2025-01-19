<?php include('../fragmente/sesiune_admin.php'); ?>
<?php
// Stergere
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM cereri_contact WHERE id=$id";
    mysqli_query($link, $query);
}

// Trimitere Email
if (isset($_POST['respond'])) {
    $id = $_POST['id'];
    $message = $_POST['response_message'];

    // Aici ar trebui să preluăm datele din tabelul cereri_contact
    $query = "SELECT * FROM cereri_contact WHERE id = $id";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $nume = $row['nume'];

    // Trimite email
    require_once('../mail/class.phpmailer.php');
    require_once('../mail/mail_config.php');

    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    try {
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "manolovesky@gmail.com";
        $mail->Password = "user@12345678";
        $mail->SetFrom("manolovesky@gmail.com", "Daw Project");
        $mail->AddReplyTo("manolovesky@gmail.com", "Daw Project");
        $mail->AddAddress($email, $nume);
        $mail->Subject = "Răspuns la solicitarea ta - Daw Project";
        $mail->Body = $message;
        $mail->Send();

        $success_message = "Mesajul a fost trimis cu succes.";
        // Redirect sau altă acțiune
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Obținem cererile din tabela cereri_contact
$result = mysqli_query($link, "SELECT * FROM cereri_contact");

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
        function showResponseForm(id, email) {
            document.getElementById('request-id').value = id;
            document.getElementById('response-message').focus();
            document.getElementById('response-form').style.display = 'block';
            document.addEventListener("DOMContentLoaded", function() {
            var formContainer = document.getElementById("form-container");
            if (formContainer && !formContainer.classList.contains("hidden")) {
                formContainer.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });
        }

        function cancelForm() {
            const formContainer = document.getElementById('response-form');
            formContainer.style.display = 'none';

            document.getElementById('response-message').value = '';
        }
      
    </script>
</head>

<body class="fixed-background">
    <?php include('../fragmente/header_admin.php'); ?>
    <main>
        <div class="container mt-4">
            <h1>Gestionare Formulare Contact</h1>
            <!-- Afisare tabel -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nume utilizator</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Mesaj</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row['nume'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['telefon'] ?></td>
                            <td><?= $row['mesaj'] ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="showResponseForm(<?= $row['id'] ?>, '<?= $row['email'] ?>');" class="btn btn-success">Răspunde</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Formular de răspuns -->
            <div class="form-container" id="response-form">
                <h3>Răspunde la cererea de contact</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="request-id">
                    <div class="mb-3">
                        <label for="response-message" class="form-label">Mesaj de răspuns</label>
                        <textarea class="form-control" id="response-message" name="response_message" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="respond" class="btn btn-primary">Trimite răspuns</button>
                    <button type="button" class="btn btn-secondary" onclick="cancelForm()">Renunță</button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
