<?php

namespace resource\Service;

use resource\Data\DrankDAO;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

class DrankService {
    
    public function getDrankOverzicht() {
        $drankDAO = new DrankDAO();
        $drankLijst = $drankDAO->getAll();
        return $drankLijst;
    }
    
    public function getEnkeleDrank($id) {
        $drankDAO = new DrankDAO();
        $thisDrank = $drankDAO->getById($id);
        return $thisDrank;
    }
    
    public function nieuweDrank($name, $price, $image, $number) {
        $drankDAO = new DrankDAO();
        $drankDAO->createDrank($name, $price, $image, $number);
    }
    
    public function updateDrank($id, $name, $price, $image, $number) {
        $drankDAO = new DrankDAO();
        $drankDAO->updateDrank($id, $name, $price, $image, $number);
    }
    
    public function verwijderDrank($id) {
        $drankDAO = new DrankDAO();
        $drankDAO->deleteDrank($id);
    }
    
    public function plusDrank($id, $verandering) {
        $drankDAO = new DrankDAO();
        $drankDAO->changeDrankAantal($id, $verandering);
    }
}