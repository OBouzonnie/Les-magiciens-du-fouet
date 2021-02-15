<!-- Template de la page d'acceuil de la section administrative -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <title>Les Magiciens Du Fouet</title>
</head>
<body>
    
    <header>
        <h1>Administration</h1>
    </header>

    <main>

        <div class="cook">

            <div class="title">
                <h2>Cuisiniers</h2>
                <a href="DBcook.php"><button class="createBtn">+</button></a>
            </div>
    
            <div class="cookList">
                <?= Cuisinier::cooks($cooks) ?>
            </div>        
        </div>
    
        <div class="recettes">

            <div class="title">
                <h2>Recettes</h2>
                <a href="DBrecette.php"><button class="createBtn">+</button></a>
            </div>
    
            <div>
                <?= ListeRecette::adminRecettes($datas) ?>
            </div>
        </div>
    </main>

    <footer>
        <form method="POST">
            <input type="submit" name="deconnexion" value="deconnexion">        
        </form>
        <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
        <p>Développement Olivier Bouzonnie</p>
    </footer>    
    
</body>
</html>