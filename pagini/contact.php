<?php
session_start();
include('../recaptcha/verify_recaptcha.php');
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$error_message = "";
$success_message = "";

if (isset($_POST['trimite'])) {
    // Verificăm dacă reCAPTCHA este valid
    if (empty($_POST['g-recaptcha-response']) || !verify_recaptcha($_POST['g-recaptcha-response'])) {
        $error_message = "Te rugăm să bifezi reCAPTCHA.";
    } else {
        // Validăm datele de contact
        $nume = mysqli_real_escape_string($link, $_POST['name']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $telefon = mysqli_real_escape_string($link, $_POST['phone']);
        $mesaj = mysqli_real_escape_string($link, $_POST['message']);

        if (empty($nume) || empty($email) || empty($mesaj)) {
            $error_message = "Toate câmpurile sunt obligatorii.";
        } else {
            // Salvăm datele în baza de date
            $query = "INSERT INTO cereri_contact (nume, email, telefon, mesaj, data_trimiterii) VALUES ('$nume', '$email', '$telefon', '$mesaj', NOW())";
            if (mysqli_query($link, $query)) {
                // Trimitem email-ul
                require_once('../mail/class.phpmailer.php');
                require_once('../mail/mail_config.php');

                $email_message = " Ai trimis un formular de contact astfel:<br>
                    <strong>Nume:</strong> $nume<br>
                    <strong>Email:</strong> $email<br>
                    <strong>Telefon:</strong> $telefon<br>
                    <strong>Mesaj:</strong><br>$mesaj
                ";

                $mail = new PHPMailer(true);
                $mail->IsSMTP();

                try {
                    $mail->SMTPDebug  = 0;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = "ssl";
                    $mail->Host       = "smtp.gmail.com";
                    $mail->Port       = 465;
                    $mail->Username   = "manolovesky@gmail.com";
                    $mail->Password   = $password;
                    $mail->AddReplyTo('manolovesky@gmail.com', 'Daw Project');
                    $mail->AddAddress("manolovesky@gmail.com", "Daw Project");
                    $mail->SetFrom('manolovesky@gmail.com', 'Daw Project');
                    $mail->Subject = 'Solicitare contact - Daw Project';
                    $mail->AltBody = 'Vizualizați acest mesaj într-un browser compatibil.';
                    $mail->AddCC("crysty799@gmail.com", "Adresa site-ului");
                    $mail->MsgHTML($email_message);
                    $mail->Send();

                    $success_message = "Mesajul a fost trimis cu succes.";
                    // Redirect către pagina de succes
                    header('Location:../index.php');
                    exit;
                } catch (phpmailerException $e) {
                    $error_message = $e->errorMessage();
                } catch (Exception $e) {
                    $error_message = $e->getMessage();
                }
            } else {
                $error_message = "A apărut o eroare la salvarea solicitării. Te rugăm să încerci din nou.";
            }
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formular Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .contact-form {
            max-width: 600px;
            margin: 100px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-submit {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-submit:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
    </style>
</head>

<body class="fixed-background">
    <div class="container">
        <div class="contact-form">
            <h1 class="form-title">Formular de Contact</h1>
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php elseif ($success_message): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nume</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Introdu numele tău" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Introdu adresa de email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefon</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Introdu numărul de telefon" required pattern="^\d+$" title="Numărul de telefon trebuie să conțină doar cifre">
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Mesaj</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Scrie mesajul tău aici" required></textarea>
                </div>
                <div class="g-recaptcha" data-sitekey="6LfZ9boqAAAAAIGMN4L0vXyOdQygUaQag7wQbQjd"></div>
                <button type="submit" name="trimite" class="btn btn-primary btn-submit w-100">Trimite</button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='../index.php'">Acasă</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('phone').addEventListener('input', function(event) {
            // Permite doar caracterele numerice
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>