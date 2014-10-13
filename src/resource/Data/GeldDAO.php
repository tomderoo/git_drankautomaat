<?php

namespace resource\Data;

use \PDO;
use \Exception;
use resource\Data\dbConfig;
use resource\Entities\Geld;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

class GeldDAO {
    
    public function getAll() {
        $geldLade = array();
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "SELECT id, waarde, aantal FROM geldlade ORDER BY id";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $thisGeld = Geld::create($rij["id"], $rij["waarde"], $rij["aantal"]);
            array_push($geldLade, $thisGeld);
        }
        $dbh = null;
        return $geldLade;
    }
    
    public function getById($id) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "SELECT id, waarde, aantal FROM geldlade WHERE id=" . $id;
        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        $foundGeld = Geld::create($rij["id"], $rij["waarde"], $rij["aantal"]);
        $dbh = null;
        return $foundGeld;
    }
    
    public function updateGeld($id, $waarde, $aantal) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $sql = "UPDATE geldlade SET ";
        $sql.= "waarde = " . $waarde . ", ";
        $sql.= "aantal = " . $aantal . " WHERE id = " . $id;
        $dbh->exec($sql);
        $dbh = null;
    }
    
    public function changeGeldInLade($waarde, $verandering) {
        $dbh = new PDO(dbConfig::$db_conn, dbConfig::$db_user, dbConfig::$db_pass);
        $tel_sql = "SELECT aantal FROM geldlade WHERE waarde=" . $waarde;
        $telResult = $dbh->query($tel_sql);
        $rij = $telResult->fetch();
        if ($rij == null) throw new Exception();
        if ($rij["aantal"] == 0 && intval($verandering == -1)) throw new Exception();
        if ($rij["aantal"] == 200 && intval($verandering == 1)) throw new Exception();
        $aantal = $rij["aantal"] + intval($verandering);
        $plus_sql = "UPDATE geldlade SET aantal = " . $aantal . " WHERE waarde = " . $waarde;
        $dbh->exec($plus_sql);
        $dbh = null;
    }
    
    public function getGeldBuidelSaldo() {
        $geldbuidelsaldo = 0;
        $geldbuidelsaldo += $_SESSION["geldbuidel"]["stuk_010"] * 10;
        $geldbuidelsaldo += $_SESSION["geldbuidel"]["stuk_020"] * 20;
        $geldbuidelsaldo += $_SESSION["geldbuidel"]["stuk_050"] * 50;
        $geldbuidelsaldo += $_SESSION["geldbuidel"]["stuk_100"] * 100;
        $geldbuidelsaldo += $_SESSION["geldbuidel"]["stuk_200"] * 200;
        return $geldbuidelsaldo;
    }
    
    public function geefWisselgeldStatus() {
        $aantal_050 = GeldDAO::getById(3)->getAantal();
        $aantal_020 = GeldDAO::getById(2)->getAantal();
        $aantal_010 = GeldDAO::getById(1)->getAantal();
        if ($aantal_050 <= 4 or $aantal_020 <= 10 or $aantal_010 <= 20) {
            return false;
        } else {
            return true;
        }
    }
    
    public function geefMuntenTerug($saldo) {
        $resterendsaldo = $saldo;
        $geldteruggave = $_SESSION["geldteruggave"];
        $aantal_200 = GeldDAO::getById(5)->getAantal();
        $aantal_100 = GeldDAO::getById(4)->getAantal();
        $aantal_050 = GeldDAO::getById(3)->getAantal();
        $aantal_020 = GeldDAO::getById(2)->getAantal();
        $aantal_010 = GeldDAO::getById(1)->getAantal();
        while ($resterendsaldo >= 200 && $aantal_200 > 0) {
            GeldDAO::changeGeldInLade(200, -1);
            $aantal_200 -= 1;
            $resterendsaldo -= 200;
            $geldteruggave["stuk_200"] += 1;
        }
        while ($resterendsaldo >= 100 && $aantal_100 > 0) {
            GeldDAO::changeGeldInLade(100, -1);
            $aantal_100 -= 1;
            $resterendsaldo -= 100;
            $geldteruggave["stuk_100"] += 1;
        }
        while ($resterendsaldo >= 50 && $aantal_050 > 0) {
            GeldDAO::changeGeldInLade(50, -1);
            $aantal_050 -= 1;
            $resterendsaldo -= 50;
            $geldteruggave["stuk_050"] += 1;
        }
        while ($resterendsaldo >= 20 && $aantal_020 > 0) {
            GeldDAO::changeGeldInLade(20, -1);
            $aantal_020 -= 1;
            $resterendsaldo -= 20;
            $geldteruggave["stuk_020"] += 1;
        }
        while ($resterendsaldo >= 10 && $aantal_010 > 0) {
            GeldDAO::changeGeldInLade(10, -1);
            $aantal_010 -= 1;
            $resterendsaldo -= 10;
            $geldteruggave["stuk_010"] += 1;
        }
        if ($resterendsaldo > 0) {
            $geldteruggave["voldaan"] = 0;
        }
        $_SESSION["geldteruggave"] = $geldteruggave;
    }
}
