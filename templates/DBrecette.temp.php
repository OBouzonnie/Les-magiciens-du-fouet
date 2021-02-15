<!-- Template de création et mise à jour de recette -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/form.css">
    <link rel="stylesheet" href="./style/DBrecette.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto&display=swap" rel="stylesheet">
    <script src="./app/DBrec.app.js" defer></script>
    <title>Les Magiciens Du Fouet</title>
</head>
<body>
    
<header>
        <h1>Administration</h1>
</header>

<main>



    <div class="DBrecette">

    <!-- enctype pour permettre l'upload de fichier -->
    <form enctype="multipart/form-data" method="POST">

        <h2>Paramètres</h2>

        <div class="diff-cout-pour-tps">

            <div class="difficulte">
                <label for="difficulte">Difficulté</label>
                <select name="difficulte" id="difficulte" required>
                    <option <?php if($difficulte == '') echo 'selected'?>></option>
                    <option value="1" <?php if($difficulte == 1) echo 'selected'?>>1</option>
                    <option value="2" <?php if($difficulte == 2) echo 'selected'?>>2</option>
                    <option value="3" <?php if($difficulte == 3) echo 'selected'?>>3</option>
                    <option value="4" <?php if($difficulte == 4) echo 'selected'?>>4</option>
                </select>
            </div>

            <div class="cout">
                <label for="cout">Coût</label>
                <select name="cout" id="cout" value="<?= $cout ?>" required>
                <option <?php if($cout == '') echo 'selected'?>></option>
                    <option value="1" <?php if($cout == 1) echo 'selected'?>>1</option>
                    <option value="2" <?php if($cout == 2) echo 'selected'?>>2</option>
                    <option value="3" <?php if($cout == 3) echo 'selected'?>>3</option>
                    <option value="4" <?php if($cout == 4) echo 'selected'?>>4</option>
                </select>
            </div>


            <div class="convives">
                <label for="convives">Pour</label>
                <input type="number" id="convives" name="convives" min="1" value="<?= $convives ?>" required>
            </div>

            <div class="temps">
                <label for="temps">Temps</label>
                <input type="time" id="temps" name="temps" value="<?= $temps ?>" required>
            </div>

        </div>        

        <div class="visibilite">
            <span>Visible ?</span>
            <input type="radio" name="visibilite" value="oui" id="visitrue" <?php if($visibilite == 1) echo 'checked'?>>
            <label for="visitrue">Oui</label>
            <input type="radio" name="visibilite" value="non" id="visifalse"  <?php if($visibilite == 0) echo 'checked'?> required>
            <label for="visifalse">Non</label>
        </div>

        <h2>Image</h2>

        <div class="imgRecette">
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <input type="file" name="avatar" id="image" <?= $req ?>>
        </div>

        <!-- Retour d'info en cas de blocage d'upload du fichier image -->
        <p class="infoImg"><?= $infoIMG ?></p>

        <h2>Recette</h2>

        <div class="cuisinier">
        <label for="cuisinier">Cuisinier</label>
        <select name="cuisinier" id="cuisinier" required>
            <option></option>
            <?= Cuisinier::cooksForm($cooks, $cuisinier); ?>
        </select>
        </div>

        <div class="titre">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" maxlength="100" value="<?= $titre ?>" required>
        </div>


        <div class="description">
        <label for="description">Description</label>
        <textarea name="description" id="description" maxlength="250" required><?= $description ?></textarea>
        </div>

        <div class="ingredients">
            <h2>Liste des ingrédients</h2>
            <div class="ingContent">
                <?= Recette::ingredientsMAJ($liste); ?>
            </div>
            <div class="ingredient-btn">Ajouter un ingrédient</div>
        </div>

        <div class="etapes">
            <h2>Étapes</h2>
            <div class="etContent">
                <?= Recette::etapesMAJ($steps); ?>
            </div>
            <div class="etape-btn">Ajouter une étape</div>
        </div>

        <div>
        <input type="submit" name="<?= $nameSub ?>" value="<?= $sub ?>">
        </div>

        <a href="admin.php" class="cancelNewRecette cancel">Annuler</a>

    </form>
    </div>

    </main>

    <footer>
        <p>MDF &copy;<?= substr(date(DATE_ATOM),0,4) ?></p>
        <p>Développement Olivier Bouzonnie</p>
    </footer>  

</body>
</html>