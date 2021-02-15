<!-- Page de suppression de cuisinier ou de recette -->

<?php 

require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/cuisinier.class.php');
require_once('classes/recette.class.php');

$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

// on récupère l'id et la nature de l'élément à supprimer (cuisinier ou recette) depuis l'url
if(isset($_GET["id"]) && isset($_GET["item"])){

    $id = $_GET["id"];
    
    //affichage si cuisinier
    if($_GET["item"] == 'cook'){        

        $cuisiniers = new Cuisinier($cnx);
    
        $cook = $cuisiniers->getCuisinier($id);
    
        $nom = $cook->nom;
        $prenom = $cook->prenom;

        $h1 = 'Supprimer Cuisinier';

        $message = 'Supprimer '.$prenom.' '.$nom.' ?<br> Attention, toutes ses recettes seront automatiquement supprimées.';
    
        //suppression si validation du formulaire
        if(isset($_POST["delete"])){
            $cuisiniers->deleteCuisinier($id);
            header('Location: admin.php');
        }
    }
    
    //affichage si recette
    if($_GET["item"] == 'recette'){
        
        $recette = new Recette($cnx);

        $recipe = $recette->getTitreRecette($id);

        $nom = $recipe->titre;

        $h1 = 'Supprimer Recette';

        $message = 'Supprimer '.$nom.' ?';

        //suppression si validation du formulaire
        if(isset($_POST["delete"])){
            $recette->deleteRecette($id);
            header('Location: admin.php');
        }
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
        <h1><?= $h1 ?></h1>
    </header>

    <main>
        <div class="container">
            <form method="POST">
                <input type="submit" name="delete" value="Oui">
                <a href="admin.php" class="cancel">Non</a>
                <p><?= $message ?></p>
            </form>
        </div> 
    </main>
    
</body>
</html>