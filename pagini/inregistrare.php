<?php
session_start();
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$error_message = "";

if (isset($_POST['register'])) {
    // Verificăm dacă câmpurile sunt completate
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error_message = "Numele de utilizator și parola sunt obligatorii.";
    } else {
        $username = mysqli_real_escape_string($link, $_POST['username']);
        $password = mysqli_real_escape_string($link, $_POST['password']);

        // Verificăm dacă utilizatorul există deja
        $result = mysqli_query($link, "SELECT * FROM utilizatori WHERE nume_utilizator='$username'");
        if (mysqli_num_rows($result) > 0) {
            $error_message = "Acest nume de utilizator este deja utilizat.";
        } else {
            // Generăm un cod aleator de verificare
            $verification_code = rand(100000, 999999);

            // Inserăm utilizatorul în baza de date cu codul de verificare
            $query = "INSERT INTO utilizatori (nume_utilizator, parola, cod_verificare, verificat, rol) VALUES ('$username', '$password', '$verification_code', 0, 'utilizator')";
            if (mysqli_query($link, $query)) {
                // Setăm sesiunea pentru utilizator
                $_SESSION['username'] = $username;

                // Trimitem email de confirmare
                require_once('../mail/class.phpmailer.php');
                require_once('../mail/mail_config.php');

                $message = "Bună, $username!<br><br>Codul tău de verificare este: <strong>$verification_code</strong>.<br>Te rugăm să introduci acest cod pentru a-ți activa contul.";

                $mail = new PHPMailer(true);
                $mail->IsSMTP();

                try {
                    $mail->SMTPDebug  = 0;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = "ssl";
                    $mail->Host       = "smtp.gmail.com";
                    $mail->Port       = 465;
                    $mail->Username   = $username;
                    $mail->Password   = $password;
                    $mail->AddReplyTo('manolovesky@gmail.com', 'Daw Project');
                    $mail->AddAddress($username, $username);
                    $mail->SetFrom('manolovesky@gmail.com', 'Daw Project');
                    $mail->Subject = 'Confirmare înregistrare';
                    $mail->AltBody = 'Te rugăm să vizualizezi acest mesaj într-un browser compatibil.';
                    $mail->MsgHTML($message);
                    $mail->Send();

                    // Redirect către pagina de succes
                    header('Location:../pagini/verificare.php');
                    exit;
                } catch (phpmailerException $e) {
                    $error_message = $e->errorMessage();
                } catch (Exception $e) {
                    $error_message = $e->getMessage();
                }
            } else {
                $error_message = "A apărut o eroare la înregistrare. Te rugăm să încerci din nou.";
            }
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Înregistrare</title>
    <?php include('../fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="fixed-background">
    <div class="container mt-5">
        <h1 class="text-center" style="color: orange;">Creare cont</h1>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label" style="color: orange;">Nume de utilizator:</label>
                <input type="text" class="form-control" id="username" name="username"
                    <?= isset($_POST['login']) ? 'required' : '' ?>>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label" style="color: orange;">Parolă:</label>
                <input type="password" class="form-control" id="password" name="password"
                    <?= isset($_POST['login']) ? 'required' : '' ?>>
            </div>
            <?php if ($show_recaptcha): ?>
                <div class="g-recaptcha mb-3" data-sitekey="6LfZ9boqAAAAAIGMN4L0vXyOdQygUaQag7wQbQjd"></div>
            <?php endif; ?>
            <button type="submit" name="register" class="btn btn-primary w-100">Înregistrare</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='./login.php'">Inapoi la Autentificare</button>
        </form>
        <?php if ($error_message) {
            echo "<p class='text-danger mt-3'>$error_message</p>";
        } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>