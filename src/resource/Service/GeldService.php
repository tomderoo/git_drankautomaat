<?php

namespace resource\Service;

use resource\Data\GeldDAO;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

class GeldService {
    
    public function getGeldlade() {
        $geldDAO = new GeldDAO();
        $geldLade = $geldDAO->getAll();
        return $geldLade;
    }
    
    public function getGeldstuk($id) {
        $geldDAO = new GeldDAO();
        $thisGeld = $geldDAO->getById($id);
        return $thisGeld;
    }
    
    public function veranderGeldInLade($waarde, $verandering) {
        $geldDAO = new GeldDAO();
        $geldDAO->changeGeldInLade($waarde, $verandering);
    }
    
    public function geefSessieSaldo() {
        $geldDAO = new GeldDAO();
        $sessiesaldo = $geldDAO->getGeldBuidelSaldo();
        return $sessiesaldo;
    }
    
    public function geefGeldStukkenTerug($saldo) {
        $geldDAO = new GeldDAO();
        $geldstukkenterug = $geldDAO->geefMuntenTerug($saldo);
        return $geldstukkenterug;
    }
    
    public function WisselgeldStatus() {
        $geldDAO = new GeldDAO();
        return $geldDAO->geefWisselgeldStatus();
    }
}