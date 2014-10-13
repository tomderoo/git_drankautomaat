<?php

use resource\Service\DrankService;
use resource\Service\GeldService;
use Doctrine\Common\ClassLoader;
use \stdClass;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

session_start();
if (!isset($_SESSION["geldbuidel"])) {
    $geldBuidel = array();
    $geldBuidel["stuk_010"] = 0;
    $geldBuidel["stuk_020"] = 0;
    $geldBuidel["stuk_050"] = 0;
    $geldBuidel["stuk_100"] = 0;
    $geldBuidel["stuk_200"] = 0;
    $_SESSION["geldbuidel"] = $geldBuidel;
}

if (!isset($_SESSION["geldteruggave"])) {
    $geldTeruggave = array();
    $geldTeruggave["stuk_010"] = 0;
    $geldTeruggave["stuk_020"] = 0;
    $geldTeruggave["stuk_050"] = 0;
    $geldTeruggave["stuk_100"] = 0;
    $geldTeruggave["stuk_200"] = 0;
    $_SESSION["geldteruggave"] = $geldTeruggave;
}

$drankService = new DrankService();

$drankLijst = $drankService->getDrankOverzicht();

if (isset($_SESSION["aankoop"])) {
    $aangekochtedrank = $drankService->getEnkeleDrank($_SESSION["aankoop"]);
    unset($_SESSION["aankoop"]);
}

$geldService = new GeldService();

$geldlade = $geldService->getGeldlade();

$sessieSaldo = $geldService->geefSessieSaldo();

$wisselgeldStatus = $geldService->WisselgeldStatus();

include("src/resource/Presentation/DrankAutomaat.php");