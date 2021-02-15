<!-- Page d'acceuil -->

<?php 
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/liste.class.php');
require_once('classes/tool.abstract.class.php');

$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/carte.css">
    <script src="app/index.app.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>

<header>
    <a href="index.php"><h1>Les Magiciens Du Fouet</h1></a>
    <a href="contact.php"><button>📧</button></a>
</header>

<main>
    
    <div class="container">  


        <!-- Version book -->
        <!-- Coté gauche -->
        <div id="ac1">
            <div id="ac2">
                <div id="animCartes">
                    <div id="cartesAnimees">
                        <?php 

                            $liste = new ListeRecette($cnx);

                            $datas = $liste->getListeRecette(32);

                            // on affiche les cartes
                            for($i = 0; $i < count($datas); $i++){

                                if($i < count($datas)){
                                    $data = $datas[$i];
                                    require('templates/carte.temp.php');
                                }
                            }
                
                        ?> 
                        </div>
                </div>
            </div>
        </div> 
            
        <!-- Coté droit -->
        <div id="alr1">
            <div id="alr2">
                <div id="animListeRecettes">
                    <div id="listeRecettes">
                        <!-- on affiche les tags -->
                        <?= ListeRecette::tags($datas) ?>
                    </div>
                </div>
            </div>
        </div>
            
        
        <!-- Version affichages de cartes simples pour les mobiles et tablettes -->
        <div class="forSmall">

                <?php 
                $index = -1;
                for($i = 0; $i <= 1; $i++){
                    $index = Tool::getRand($datas,$index);
                    $data = $datas[$index];
                    require('templates/carte.temp.php');
                }
                ?>
        </div>

       

    </div>

    <div class="fil">
        <a href="allRecettes.php"><h2>Toutes nos recettes</h2></a>
    </div>

    
    
</main>

<footer>
    <a href="login.php"><button>Administration</button></a>
    <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
    <p>Développement Olivier Bouzonnie</p>
</footer>

    
</body>
</html>







