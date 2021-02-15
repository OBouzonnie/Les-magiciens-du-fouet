<!-- Template d'affichage d'une recette -->

<?php 
    require_once('./classes/recette.class.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/recipe.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>
    
    <header>
        <h1><?= $data->titre ?></h1>
        <figure>
            <img src="./images/<?= $data->idRecette?>.jpg" alt="image du plat">
        </figure>
    </header>

    <main>    
        
    <div class="container">

            <div class="preparation">
                <div class="cookingInfo">
                    <p><?= Recette::temps($data->temps) ?></p>
                    <p>pour <?= $data->nbreConvives ?></p>
                    <div class="euro">
                        <?= Recette::euro($data->cout) ?>
                    </div>
                    <div>
                    <?= Recette::fouet($data->difficulte) ?>
                    </div>
                </div>
            
                <div class="ingredients">
                    <div>                    
                        <h2>Les ingrédients</h2>
                        <ul>
                            <?= Recette::ingredients($data->liste) ?>
                        </ul>
                    </div>
                </div>
            </div>

    
            <div class="etapes">
                <div>
                    <h2>Les étapes</h2>
                    <ol>
                        <?= Recette::etapes($data->etapes) ?>
                    </ol>                    
                </div>
            </div>
        </div>

        <p class='fil'>
            <span>Vous êtes à</span>
            <span class="mdf"> Les magiciens du fouet </span>
            <span> <?= $data->titre ?> </span>
        </p>
    </main>

    <footer>
        <a href="allRecettes.php">Retour à la liste</a>
        <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
        <p>Développement Olivier Bouzonnie</p>
    </footer>
    
</body>
</html>