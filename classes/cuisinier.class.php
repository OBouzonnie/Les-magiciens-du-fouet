<?php

class Cuisinier{

    private object $bdd;

    public function __construct(object $cnx){
        $this->bdd = $cnx;
    }

    //
    //
    //fonctions de requêtes à la DB
    //
    //

    public function getCuisinier($id){

        try{
            $requete = 'SELECT * FROM cuisinier WHERE idCuisinier='.$id;
            $requestSent = $this->bdd->query($requete);
            $data = $requestSent->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        catch (PDOException $e){
            echo $e;
        }

    }

    public function getListeCuisiniers(){

        $retour = [];
        $i = 0;

        try{
            $requete = 'SELECT * FROM cuisinier';
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

    public function deleteCuisinier(int $id){
        $id = filter_var($id, FILTER_VALIDATE_INT);

        try{
            $requete = "DELETE FROM cuisinier WHERE idCuisinier =".$id;
            $sent = $this->bdd->prepare($requete);
            $sent->execute();

        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function createCuisinier(string $nom, string $prenom){

        $nom = filter_var(preg_replace('/[\s0-9]/','', $nom), FILTER_SANITIZE_STRING);
        $prenom = filter_var(preg_replace('/[\s0-9]/','', $prenom), FILTER_SANITIZE_STRING);

        try{
            $requete = 'INSERT INTO cuisinier (nom, prenom) VALUES (:nom, :prenom)';
            $sent = $this->bdd->prepare($requete);
            $sent->bindValue(':nom', ucfirst(strtolower($nom)), PDO::PARAM_STR);
            $sent->bindValue(':prenom', ucfirst(strtolower($prenom)), PDO::PARAM_STR);
            $sent->execute();

        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function majCuisinier(string $nom, string $prenom, int $id){

        $nom = filter_var(preg_replace('/[\s0-9]/','', $nom), FILTER_SANITIZE_STRING);
        $prenom = filter_var(preg_replace('/[\s0-9]/','', $prenom), FILTER_SANITIZE_STRING);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        try{
            $requete = "UPDATE cuisinier SET nom = :nom, prenom = :prenom WHERE idCuisinier =".$id;
            $sent = $this->bdd->prepare($requete);
            $sent->bindValue(':nom', ucfirst(strtolower($nom)), PDO::PARAM_STR);
            $sent->bindValue(':prenom', ucfirst(strtolower($prenom)), PDO::PARAM_STR);
            $sent->execute();

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

    //mise en forme de la liste des cuisiniers de la section admin
    public static function cooks(array $cooks){

        $cooksAffich = '';

        for($i=0; $i<count($cooks); $i++){
            $cooksAffich .= '
            <div class="item cookItem">
                <a href="DBcook.php?&id='.$cooks[$i]->idCuisinier.'" class="editBtn"><button>🖋</button></a>
                <span>'.$cooks[$i]->nom.' '.$cooks[$i]->prenom.'</span>
                <a href="delete.php?item=cook&id='.$cooks[$i]->idCuisinier.'" class="deleteBtn"><button>✖</button></a>
            </div>
            ';
        }

        return $cooksAffich;
    }

    //mise en forme du menu déroulant des cuisiniers sur le formulaire de création/mise à jour de recette
    public static function cooksForm(array $cooks, int $id){

        $cooksDeroule = '';

        for($i=0; $i<count($cooks); $i++){
            if($id == $cooks[$i]->idCuisinier){
                $sel = 'selected';
            }
            else{
                $sel = '';
            }
            $cooksDeroule .= '
            <option value="'.$cooks[$i]->idCuisinier.'" '.$sel.'>'.$cooks[$i]->prenom.' '.$cooks[$i]->nom.'</option>
            ';
            $sel = '';
        }

        return $cooksDeroule;
    }
}
?>