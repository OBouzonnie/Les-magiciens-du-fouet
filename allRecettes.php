<!-- Page d'affichage de toutes la pagination de la liste complète des recettes -->

<?php 
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/liste.class.php');

//si l'url contient une référence de page, récupère cette valeur, sinon on la fixe à 1
if(!isset($_GET["page"])){
    $page = 1;
}
else{
    $page = $_GET["page"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/carte.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>

<header>
    <a href="index.php"><h1>Les Magiciens Du Fouet</h1></a>
    <a href="contact.php"><button>📧</button></a>
</header>

<main>

    <h2>Nos recettes</h2>
    
    <div class="container">
        
    
        <?php 

            $bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

            $cnx = $bdd->cnx();

            $liste = new ListeRecette($cnx);

            $datas = $liste->getListeRecette();

            // à partir de la liste complète des recettes, on calcule le nombre de page qui doit être indiqué dans le fil de pagination, à raison de 12 recette par page
            if(count($datas)%12 == 0){
                //si le nombre de page est pile un multiple de 12
                $nbrePage = count($datas)/12;
            }
            else{
                //sinon on ajoute une page pour les dernières recettes
                $nbrePage = floor(count($datas)/12) + 1;
            } 

            //affichage des 12 recettes de la $_GET["page"] en cours
            for($i = ($page * 12) - 12; $i < $page * 12; $i++){

                if($i < count($datas)){
                    $data = $datas[$i];
                    require('templates/carte.temp.php');
                }
            }  
    
        ?>   
       

    </div>
    
    <div class="fil">
        <?php 

            //fil de pagination crée dynamiquement
            for($i = 1; $i <= $nbrePage; $i++){
                echo '<a href="allRecettes.php?page='.$i.'">'.$i.'</a>';
            }
        ?>
    </div>

    
    
</main>

<footer>
    <a href="login.php"><button>Administration</button></a>
    <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
    <p>Développement Olivier Bouzonnie</p>
</footer>

    
</body>
</html>







