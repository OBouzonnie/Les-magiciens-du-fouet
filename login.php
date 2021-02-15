<!-- Page de login à la section administrateur -->

<?php
session_start();
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/liste.class.php');
require_once('classes/recette.class.php');
require_once('classes/cuisinier.class.php');
require_once('classes/login.class.php');

$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

$log = new Login($cnx);

// variable qui stockera le message en cas d'échec de login
$info ='';

if(isset($_POST["connexion"])){

    if(empty($_POST["login"]) || empty($_POST["pwd"])){
        $info = 'Veuillez renseigner les champs';
    }
    else{        
        $connexion = $log->getAdmin($_POST["login"], $_POST["pwd"]);
        if(!$connexion){
            $info = 'Administrateur non reconnu';
        } else {
            // création des superglobales de sessions
            $_SESSION["log"] = $connexion->login;
            $_SESSION["id"] = $connexion->idAdmin;
            //renvoi vers la page d'admin
            header('Location: admin.php');
        }
    }
}

//fin de session et renvoi vers l'index en cas d'annulation
if(isset($_POST["retour"])){

    $log->deconnexion();
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/login.css">
    <script src="app/log.app.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>
    
    <header>
        <h1>Administration</h1>
    </header>

    <main>

        <form method="POST">

            <div>
                <input type="text" name="login" maxlength="25" placeholder="Login">
            </div>

            <div class="pwd">
                <input type="number" name="pwd" maxlength="6" placeholder="Mot de Passe" readonly>
                <div id="delPwd">Supprimer</div>
            </div>

            <p id="info"><?= $info ?></p>

            <div class="numPad">
            </div>

            <input type="submit" name="connexion" value="Connexion">

        </form>

    </main>

    <footer>
        <form method="POST">
            <input type="submit" name="retour" value="Acceuil">        
        </form>
        <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
        <p>Développement Olivier Bouzonnie</p>
    </footer>    
    
</body>
</html>