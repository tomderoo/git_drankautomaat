<?php

namespace resource\Data;

use \PDO;
use \Exception;
use resource\Data\dbConfig;
use resource\Entities\Drank;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

class DrankDAO {
    
    public function getAll() {
        $drankLijst = array();
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "SELECT id, name, price, image, number FROM drank ORDER BY price ASC, name";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            //print($rij["id"].$rij["name"].$rij["price"].$rij["image"].$rij["number"]."<br>");
            $thisDrank = Drank::create($rij["id"], $rij["name"], $rij["price"], $rij["image"], $rij["number"]);
            array_push($drankLijst, $thisDrank);
        }
        $dbh = null;
        return $drankLijst;
    }
    
    public function getById($id) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "SELECT * FROM drank WHERE id=" . $id;
        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        $foundDrank = Drank::create($rij["id"], $rij["name"], $rij["price"], $rij["image"], $rij["number"]);
        $dbh = null;
        return $foundDrank;
    }
    
    /*public function createDrank($name, $price, $image, $number) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "INSERT INTO drank (name, price, image, number) VALUES (";
        $sql .= "'" . $name . "', ";
        $sql .= "" . $price . ", ";
        $sql .= "'" . $image . "', ";
        $sql .= "" . $number . ")";
        $dbh->exec($sql);
        $dbh = null;
    }*/
    
    /*public function updateDrank($id, $name, $price, $image, $number) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "UPDATE drank SET ";
        $sql.= "name = '" . $name . "', ";
        $sql.= "price = " . $price . ", ";
        $sql.= "image = '" . $image . "', ";
        $sql.= "number = " . $number . " WHERE id = " . $id;
        $dbh->exec($sql);
        $dbh = null;
    }*/
    
    public function changeDrankAantal($id, $verandering) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $tel_sql = "SELECT number FROM drank WHERE id = " . $id;
        $telResult = $dbh->query($tel_sql);
        $rij = $telResult->fetch();
        if ($rij == null) throw new Exception();
        if ($rij["number"] == 0 && intval($verandering) == -1) throw new Exception();
        if ($rij["number"] == 20 && intval($verandering) == 1) throw new Exception();
        $aantal = $rij["number"] + intval($verandering);
        $plus_sql = "UPDATE drank SET number = " . $aantal . " WHERE id = " . $id;
        print($plus_sql);
        $dbh->exec($plus_sql);
        $dbh = null;
    }
    
    /*public function deleteDrank($id) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "DELETE FROM drank WHERE id = " . $id;
        $dbh->exec($sql);
        $dbh = null;
    }*/
}
