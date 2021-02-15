<?php 

class Bdd{

    private string $dsn;
    private object $cnx;

    public function __construct(string $driver, string $host, string $port, string $db, string $charset, string $log, string $pwd){
        $this->dsn = $driver.':host='.$host.';port='.$port.';dbname='.$db.';charset='.$charset;
        try{
            $this->cnx = new PDO($this->dsn, $log, $pwd);
            $this->cnx->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch(PDOException $e){
            echo $e;
        }
    }

    public function cnx(){
        return $this->cnx;
    }

}

?>