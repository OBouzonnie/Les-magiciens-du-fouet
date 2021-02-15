<!-- Page d'affichage d'une recette -->

<?php 
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/recette.class.php');

//récupération de l'id de la recette depuis l'url
$id = $_GET['id'];

//connexion à la BDD
$bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);

$cnx = $bdd->cnx();

//récupération et affichage
$recette = new Recette($cnx);

$data = $recette->getRecette($id);

require('templates/recette.temp.php');

?>

