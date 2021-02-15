<!-- Page de création et de mise à jour d'un cuisinier -->

<?php 

require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/cuisinier.class.php');

$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

$cuisiniers = new Cuisinier($cnx);

//si l'url ne contient pas une variable id, alors on accède à cette page depuis le bouton de création de cuisinier et on affiche simplement le template du formulaire vide
if(!isset($_GET["id"])){
    $nom = '';
    $prenom = '';
    $sub = 'Ajouter';

    if(isset($_POST["submit"])){
        if(isset($_POST["nom"]) && isset($_POST["prenom"]))
        $cuisiniers->createCuisinier($_POST["nom"], $_POST["prenom"]);
        header('Location: admin.php');
    }
}
else{
//sinon on accède à cette page depuis le bouton de mise à jour d'une recette et on récupère les enregistrements de ce cuisinier depuis la base correspond au $-GET["id"] pour les afficher comme value des champs du formulaire
    $id = $_GET["id"];

    $cook = $cuisiniers->getCuisinier($id);

    $nom = $cook->nom;
    $prenom = $cook->prenom;
    $sub = 'Mettre à jour';

    if(isset($_POST["submit"])){
        if(isset($_POST["nom"]) && isset($_POST["prenom"]))
        $cuisiniers->majCuisinier($_POST["nom"], $_POST["prenom"], $id);
        header('Location: admin.php');
    }

    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>

    <header>
        <h1>Cuisinier</h1>
    </header>

    <main>
        <div>
            <form method="POST">
                <input type="text" name="nom" placeholder="Nom" maxlength="20" value="<?= $nom ?>" required>
                <input type="text" name="prenom" placeholder="Prenom" maxlength="20" value="<?= $prenom ?>" required>
                <input type="submit" name="submit" value="<?= $sub ?>">
                <a href="admin.php"class="cancel">Annuler</a>
            </form>
        </div> 
    </main>

    <footer>
        <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
        <p>Développement Olivier Bouzonnie</p>
    </footer> 
    
</body>
</html>