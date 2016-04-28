<?php
//BerichtHandelingen.php
require_once ("Bericht.php");

class BerichtLijst{
    
    private $dbConn;
    private $dbUsername;
    private $dbPassword;
    
    public function __construct(){
        $this->dbConn = "mysql:host=127.0.0.1;dbname=cursusphp;charset=utf8";
        $this->dbUsername = "cursusgebruiker";
        $this->dbPassword = "cursuspwd";
    }
    
    public function getLijst() {
        $sql = "select * from gastenboek order by datum";
        $dbh = new PDO($this->dbConn, $this->dbUsername, $this->dbPassword);
        $resultSet = $dbh->query($sql);
        
        $lijst = array();
        foreach ($lijst as $rij){
            $bericht = new Bericht($rij['id'], $rij['auteur'], $rij['boodschap'], $rij['datum']);
            array_push($lijst, $bericht);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function createBericht($auteur, $boodschap, $datum){
        if (!empty($auteur) && !empty($boodschap)){
            
            $sql = "insert into gastenboek (auteur, boodschap, datum) values (:auteur, :boodschap, :datum)";
            $dbh = new PDO($this->dbConn, $this->dbUsername, $this->dbPassword);
            
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':auteur' => $auteur, ':boodschap' => $boodschap, ':datum' => $datum));
            $dbh = null;
        }
    }
}