<!-- Page de contact -->

<?php
require_once('config.php');
require('classes/contact.class.php');

$contact = new Contact(OWNER, MAILTARGET, MAILFROM, SMTPSERVER, SMTPPORT, SMTPSECURE, SMTPUSERNAME, SMTPPASSWORD);
$sendMessage = '';

if(isset($_POST["envoyer"])){

    $sendMessage = $contact->sendMail($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["message"]);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <script src="./app/admin.js" defer></script>
    <title>Les Magiciens Du Fouet</title>
</head>
<body>

    <header>
        <h1>Contact</h1>
    </header>

    <main>
        <form  method="POST">
            <input type="text" name="nom" placeholder="Nom" maxlength="25">
            <input type="text" name="prenom" placeholder="Prénom" maxlength="25">
            <input type="email" name="email" placeholder="Email" maxlength="50" required>
            <textarea name="message" placeholder="Message"></textarea>
            <input type="submit" name="envoyer" value="envoyer">
        </form>

        <p><?= $sendMessage ?></p>
    </main>

<footer>
    <a href="index.php"><button>Retour</button></a>
    <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
    <p>Développement Olivier Bouzonnie</p>
</footer>
    
</body>
</html>