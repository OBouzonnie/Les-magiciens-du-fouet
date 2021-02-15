<?php

class ListeRecette{

    private object $bdd;

    public function __construct(object $cnx){
        $this->bdd = $cnx;
    }

    //
    //
    //fonctions de requêtes à la DB
    //
    //

    public function getListeRecette(int $length = 0){

        $retour = [];
        $i = 0;
        
        if($length > 0){
            $limit = ' LIMIT '.$length;
        }
        else{
            $limit = '';
        }

        try{
            $requete = 'SELECT * FROM recettes LEFT JOIN cuisinier USING(idCuisinier) WHERE visibilite = 1'.$limit;
            $requestSent = $this->bdd->query($requete);
            while($data = $requestSent->fetch(PDO::FETCH_OBJ)){
                $retour[$i] = $data;
                $i++;
            }
            return $retour;
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function getAdminListe(){

        $retour = [];
        $i = 0;

        try{
            $requete = 'SELECT idRecette, titre FROM recettes';
            $requestSent = $this->bdd->query($requete);
            while($data = $requestSent->fetch(PDO::FETCH_OBJ)){
                $retour[$i] = $data;
                $i++;
            }
            return $retour;
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    //
    //
    //fonctions servant à générer des petites parties de templates
    //
    //

    //mise en forme de la liste des recettes de la zone admin
    public static function adminRecettes(array $liste){

        $recetteAffich = '';

        for($i=0; $i<count($liste); $i++){
            $recetteAffich .= '
            <div class="item">
                <a href="DBrecette.php?id='.$liste[$i]->idRecette.'" class="editBtn"><button>🖋</button></a>
                <span>'.$liste[$i]->titre.'</span>
                <a href="delete.php?item=recette&id='.$liste[$i]->idRecette.'" class="deleteBtn"><button>✖</button></a>
            </div>
            ';
        }

        return $recetteAffich;
    }

    //mise en forme de la liste des recettes affichées sur la page d'acceuil sur des écrans larges
    public static function tags(array $liste){

        $recetteAffich = '';

        for($i=3; $i<count($liste); $i++){
            $recetteAffich .= '
            <a href="recette.php?id='.$liste[$i]->idRecette.'">
                <div class="tag">
                    <span>'.$liste[$i]->titre.'</span>
                </div>
            </a>
            ';
        }

        return $recetteAffich;
    }


}
?>