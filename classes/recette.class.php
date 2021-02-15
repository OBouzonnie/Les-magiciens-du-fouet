<?php

class Recette{

    private object $bdd;

    public function __construct(object $cnx){
        $this->bdd = $cnx;
    }

    //
    //
    //fonctions de requêtes à la DB
    //
    //

    public function getLastRecetteID(){

        try{
            $requete = 'SELECT idRecette FROM recettes ORDER BY idRecette DESC LIMIT 1';
            $requestSent = $this->bdd->query($requete);
            $data = $requestSent->fetch(PDO::FETCH_OBJ);
            return $data->idRecette;
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function getTitreRecette(int $id){

        try{
            $requete = 'SELECT titre FROM recettes WHERE idRecette ='.$id;
            $requestSent = $this->bdd->query($requete);
            return $requestSent->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e){
            echo $e;
        }

    }

    public function getRecette(int $id){

        try{
            $requete = 'SELECT * FROM recettes LEFT JOIN cuisinier USING(idCuisinier) WHERE idRecette = '.$id;
            $requestSent = $this->bdd->query($requete);
            return $requestSent->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e){
            echo $e;
        }

    }

    public function deleteRecette(int $id){
        $id = filter_var($id, FILTER_VALIDATE_INT);

        try{
            $requete = "DELETE FROM recettes WHERE idRecette =".$id;
            $sent = $this->bdd->prepare($requete);
            $sent->execute();

        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function createRecette(int $difficulte, int $cout, int $convives, string $temps, int $cuisinier, string $titre, string $description, bool $visibilite, string $ingredients, string $etapes, string $date){

        $this->filtres($difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date);

        try{
            $requete = 'INSERT INTO recettes (difficulte, cout, nbreConvives, temps, idCuisinier, titre, description, visibilite, liste, etapes, date) 
            VALUES (:difficulte, :cout, :nbreConvives, :temps, :idCuisinier, :titre, :description, :visibilite, :liste, :etapes, :date)';
            
            $this->execution($requete, $difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date);
        }
        catch (PDOException $e){
            echo $e;
        }

    }

    

    public function majRecette(int $difficulte, int $cout, int $convives, string $temps, int $cuisinier, string $titre, string $description, bool $visibilite, string $ingredients, string $etapes, string $date, int $id){

        $this->filtres($difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date);

        $id = filter_var($id, FILTER_VALIDATE_INT);

        try{
            $requete = 'UPDATE recettes SET difficulte = :difficulte, cout = :cout, nbreConvives = :nbreConvives, temps = :temps, idCuisinier = :idCuisinier, titre = :titre, description = :description, visibilite = :visibilite, liste = :liste, etapes = :etapes, date = :date WHERE idRecette='.$id;
            
            $this->execution($requete, $difficulte, $cout, $convives, $temps, $cuisinier, $titre, $description, $visibilite, $ingredients, $etapes, $date);
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    //
    //
    //fonctions servant à factoriser des codes réutilisés dans plusieurs requêtes
    //
    //

    //filtres des fonctions de création et de mise à jour de recette
    private function filtres(int $difficulte, int $cout, int $convives, string $temps, int $cuisinier, string $titre, string $description, bool $visibilite, string $ingredients, string $etapes, string $date){

        try{
            $requete = 'SELECT idCuisinier FROM cuisinier ORDER BY idCuisinier DESC LIMIT 1';
            $requestSent = $this->bdd->query($requete);
            $requestResult = $requestSent->fetch(PDO::FETCH_OBJ);
            $nbrCuisinier = $requestResult->idCuisinier;
        }
        catch (PDOException $e){
            echo $e;
        }

        $difficulte = filter_var($difficulte, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 4
            )
        ));

        $cout = filter_var($difficulte, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 4
            )
        ));

        $convives = filter_var($difficulte, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => 1
            )
        ));

        $temps = filter_var($temps, FILTER_VALIDATE_REGEXP, array(
            'options' => array(
                'regexp' => '/^(0[0-9]|1[0-2]):([0-5][0-9])/'
            )
        ));

        $cuisinier = filter_var($cuisinier, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => 1,
                'max_range' => $nbrCuisinier
            )
        ));

        $titre = filter_var($titre, FILTER_SANITIZE_STRING);

        $description = filter_var($description, FILTER_SANITIZE_STRING);

        $visibilite = filter_var($visibilite, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => 0,
                'max_range' => 1
            )
        ));

        $ingredients = filter_var($ingredients, FILTER_SANITIZE_STRING);

        $etapes = filter_var($etapes, FILTER_SANITIZE_STRING);


        $date = filter_var($date, FILTER_VALIDATE_REGEXP, array(
            'options' => array(
                'regexp' => '/^[0-9]{4}-((01|03|05|07|08|10|12)-(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)-(0[1-9]|[1-2][0-9]|30)|02-(0[1-9]|1[0-9]|2[0-9]))/'
            )
        ));

    }

    //bind values et execution de requete des fonctions de créations et de mise à jour de recette
    private function execution(string $requete, int $difficulte, int $cout, int $convives, string $temps, int $cuisinier, string $titre, string $description, bool $visibilite, string $ingredients, string $etapes, string $date){
        
        $sent = $this->bdd->prepare($requete);
        $sent->bindValue(':difficulte', $difficulte, PDO::PARAM_INT);
        $sent->bindValue(':cout', $cout, PDO::PARAM_INT);
        $sent->bindValue(':nbreConvives', $convives, PDO::PARAM_INT);
        $sent->bindValue(':temps', $temps, PDO::PARAM_STR);
        $sent->bindValue(':idCuisinier', $cuisinier, PDO::PARAM_INT);
        $sent->bindValue(':titre', $titre, PDO::PARAM_STR);
        $sent->bindValue(':description', $description, PDO::PARAM_STR);
        $sent->bindValue(':visibilite', $visibilite, PDO::PARAM_INT);
        $sent->bindValue(':liste', $ingredients, PDO::PARAM_STR);
        $sent->bindValue(':etapes', $etapes, PDO::PARAM_STR);
        $sent->bindValue(':date', $date, PDO::PARAM_STR);
        $sent->execute();
    }

    //
    //
    //fonctions servant à générer des petites parties de templates
    //
    //

    //mise en forme des logos de cout
    public static function euro(int $cout){

        $euro = '';
        for($i = 0; $i < $cout; $i++){
            $euro .= '<span>&euro;</span>';
        }
        return $euro;
    }

    //mise en forme des icones de difficulté
    public static function fouet(int $difficulte){

        $fouet = '';       
    
        for($i = 0; $i < $difficulte; $i++){
            $fouet .= '<span><img src="images/fouet.png" alt="icone fouet"></span>';
        }

        return $fouet;
    }

    //mise en forme du champ temps
    public static function temps(string $temps){

        $tps = '';
        $tabTps = explode(':', $temps, 3);
        if($tabTps[0] != 0){
            $tps .= $tabTps[0].'h'.$tabTps[1];
        }
        else{
            $tps .= $tabTps[1].'min';
        }

        return $tps;
    }

    //mise en forme de la liste d'ingrédients sur la page d'affichage d'une recette
    public static function ingredients(string $liste){

        $listeTab = explode('###', $liste);

        $ingredients = '';

        for($i=0; $i<count($listeTab)-1; $i++){
            $ingredients .= '<li>'.$listeTab[$i].'</li>';
        }

        return $ingredients;
    }

    //mise en forme de la liste des étapes sur la page d'affichage d'une recette
    public static function etapes(string $etapes){

        $listeEtapes = explode('###', $etapes);

        $steps = '';

        for($i=0; $i<count($listeEtapes)-1; $i++){
            $steps .= '<li>'.$listeEtapes[$i].'</li>';
        }

        return $steps;
    }

    //mise en forme de la liste d'ingrédients dans des champs input sur la page de mise à jour d'une recette
    public static function ingredientsMAJ(string $liste){

        $listeTab = explode('###', $liste);

        $ingredients = '';

        for($i=0; $i<count($listeTab)-1; $i++){
            $ingredients .= '<input class="ing" type="text" maxlength="50" name="ing'.$i.'" value="'.$listeTab[$i].'">';
        }

        return $ingredients;
    }


    //mise en forme de la liste des étapes dans des champs textarea sur la page de mise à jour d'une recette
    public static function etapesMAJ(string $etapes){

        $listeEtapes = explode('###', $etapes);

        $steps = '';

        for($i=0; $i<count($listeEtapes)-1; $i++){
            $steps .= '<textarea class="etape" name="et'.$i.'" maxlength="500">'.$listeEtapes[$i].'</textarea>';
        }

        return $steps;
    }
}
?>