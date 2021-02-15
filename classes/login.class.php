<?php 

class Login{


    private object $bdd;

    public function __construct(object $cnx){
        $this->bdd = $cnx;
    }

    public function getAdmin($login, $pwd){

        $login = filter_var($login, FILTER_SANITIZE_STRING);
        $pwd = filter_var($pwd, FILTER_SANITIZE_STRING);

        try{
            $requete = 'SELECT * FROM admin WHERE login = :login AND password = :pwd';
            $requestSent = $this->bdd->prepare($requete);
            $requestSent->bindValue(':login', $login, PDO::PARAM_STR);
            $requestSent->bindValue(':pwd', $pwd, PDO::PARAM_STR);
            $requestSent->execute();
            return $requestSent->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function getAdminByID($id){

        $id = filter_var($id, FILTER_VALIDATE_INT);

        try{
            $requete = 'SELECT idAdmin, login FROM admin WHERE idAdmin = :id';
            $requestSent = $this->bdd->prepare($requete);
            $requestSent->bindValue(':id', $id, PDO::PARAM_INT);
            $requestSent->execute();
            return $requestSent->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e){
            echo $e;
        }
    }

    public function randomPad(){
        $pad = ['0','1','2','3','4','5','6','7','8','9','','','','','',''];
        shuffle($pad);
        $padTemp = '';
        foreach($pad as $val){
            $padTemp .= '<div class="bloc">'.$val.'</div>';
        }
        return $padTemp;
    }

    public function deconnexion(){

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();;
    }

}
?>