<!-- Page de création et mise à jour d'une recette -->

<?php 
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/cuisinier.class.php');
require_once('classes/recette.class.php');
require_once('classes/tool.abstract.class.php');

$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

$cuisiniers = new Cuisinier($cnx);

$recette = new Recette($cnx);

$cooks = $cuisiniers->getListeCuisiniers();

$infoIMG = '';

//si l'url ne contient pas une variable id, alors on accède à cette page depuis le bouton de création de recette et on affiche simplement le template du formulaire vide
//sinon on accède à cette page depuis le bouton de mise à jour d'une recette et on récupère les enregistrements de cette recette correspondant au $_GET["id"] depuis la base pour les afficher comme value des champs du formulaire

if(!isset($_GET["id"])){

    //pas d'id, les champs du formulaire sont vides
    $id = 0;
    $sub = 'Ajouter';
    $req = '';
    $nameSub = 'addRecette';

    $visibilite = 0;
    $difficulte = '';
    $cout = '';
    $convives = '';
    $temps = '';
    $cuisinier = 0;
    $titre = '';
    $description = '';
    $liste = '';
    $steps = '';
    $ingredients = '';
    $etapes = '';

    
    //ajout de la recette à la base
    if(isset($_POST["addRecette"])){

        $date = substr(date(DATE_ATOM),0,10);

        $visibilite = $_POST["visibilite"];
        $difficulte = $_POST["difficulte"];
        $cout = $_POST["cout"];
        $convives = $_POST["convives"];
        $temps = $_POST["temps"];
        $cuisinier = $_POST["cuisinier"];
        $titre = $_POST["titre"];
        $description = $_POST["description"];
    
        //récupération des données des champs ingrédients, dont le nombre est variable
        $i=0;
        $ingredients = '';
    
        while(isset($_POST['ing'.$i])){
            $ingredients .= $_POST['ing'.$i].'###';
            $i++;
        }
        
        //récupération des données des champs étapes, dont le nombre est variable
        $j=0;
        $etapes = '';
    
        while(isset($_POST['et'.$j])){
            $etapes .= $_POST['et'.$j].'###';
            $j++;
        }
    
        //Traduction du booléen de visibilité
        if($visibilite == 'oui'){
            $visibilite = 1;
        }
        else{
            $visibilite = 0;
        }
        
        $recette->createRecette($difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date);

        //on récupère la dernière id de recette de la table recette (celle que nous venons d'injecter)
        $idImg = $recette->getLastRecetteID();

        //on crée stocke l'image uploadé avec le formulaire sous ce nom
        $infoIMG = Tool::uploadImg($idImg);
    
        header('Location: admin.php');
    }

}
else{

    //id reçue, les champs du formulaire contiennent les informations récupérées depuis la base
    $id = $_GET["id"];
    $sub = 'Mettre à jour';
    $req = '';
    $nameSub = 'majRecette';

    $data = $recette->getRecette($id);

    $date = $data->date;
    $visibilite = $data->visibilite;
    $difficulte = $data->difficulte;
    $cout = $data->cout;
    $convives = $data->nbreConvives;
    $temps = $data->temps;
    $cuisinier = $data->idCuisinier;
    $titre = $data->titre;
    $description = $data->description;
    $liste = $data->liste;
    $steps = $data->etapes;
    $ingredients = '';
    $etapes = '';
    
    //mise à jour de la recette dans la base
    if(isset($_POST["majRecette"])){
    
        $infoDB = '';
        $visibilite = $_POST["visibilite"];
        $difficulte = $_POST["difficulte"];
        $cout = $_POST["cout"];
        $convives = $_POST["convives"];
        $temps = $_POST["temps"];
        $cuisinier = $_POST["cuisinier"];
        $titre = $_POST["titre"];
        $description = $_POST["description"];
    
        //récupération des données des champs ingrédients, dont le nombre est variable
        $i=0;
        $ingredients = '';
    
        while(isset($_POST['ing'.$i])){
            $ingredients .= $_POST['ing'.$i].'###';
            $i++;
        }
    
        //récupération des données des champs étapes, dont le nombre est variable
        $j=0;
        $etapes = '';
    
        while(isset($_POST['et'.$j])){
            $etapes .= $_POST['et'.$j].'###';
            $j++;
        }
        
        //Traduction du booléen de visibilité
        if($visibilite == 'oui'){
            $visibilite = 1;
        }
        else{
            $visibilite = 0;
        }        
    
        $recette->majRecette($difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date, $id);

        $infoIMG = Tool::uploadImg($id);
    
        header('Location: admin.php');
    }   

}

require('templates/DBrecette.temp.php');
?>

