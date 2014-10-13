<?php

if (!isset($_GET["act"])) {
    header("location: drankautomaat.php");
}

use resource\Service\DrankService;
use resource\Service\GeldService;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

session_start();

if (!isset($_SESSION["geldteruggave"])) {
    $geldTeruggave = array();
    $geldTeruggave["stuk_010"] = 0;
    $geldTeruggave["stuk_020"] = 0;
    $geldTeruggave["stuk_050"] = 0;
    $geldTeruggave["stuk_100"] = 0;
    $geldTeruggave["stuk_200"] = 0;
    $_SESSION["geldteruggave"] = $geldTeruggave;
}

//print_r($_GET);
//print_r($_POST);
$action = $_GET["act"];

switch ($action) {
    case "werpmunt":
        if (isset($_POST["munt"]) && is_numeric($_POST["munt"])) {
            $munt = intval($_POST["munt"]);
        } else {
            header("location: drankautomaat.php");
        }
        $geldService = new GeldService();
        try {
            $geldService->veranderGeldInLade($munt, +1);
            switch ($munt) {
                case 10:
                    $_SESSION["geldbuidel"]["stuk_010"] += 1;
                    break;
                case 20:
                    $_SESSION["geldbuidel"]["stuk_020"] += 1;
                    break;
                case 50:
                    $_SESSION["geldbuidel"]["stuk_050"] += 1;
                    break;
                case 100:
                    $_SESSION["geldbuidel"]["stuk_100"] += 1;
                    break;
                case 200:
                    $_SESSION["geldbuidel"]["stuk_200"] += 1;
                    break;
                default:
                    header("location: drankautomaat.php");
                    break;
            }
            header("location: drankautomaat.php");
        } catch (Exception $ex) {
            header("location: drankautomaat.php?error=muntinwerp");
        }
        break;
    
    case "geldterug":
        $geldService = new GeldService();
        $terug_aantal = $geldService->geefSessieSaldo();
        $geldService->geefGeldStukkenTerug($terug_aantal);
        unset($_SESSION["geldbuidel"]);
        header("location: drankautomaat.php");
        break;
    
    case "kiesdrank":
        $drank_id = $_GET["id"];
        $drankService = new DrankService();
        $geldService = new GeldService();
        try {
            $drankService->plusDrank($drank_id, -1);
            $terug_aantal = $geldService->geefSessieSaldo();
            $drankprijs = $drankService->getEnkeleDrank($drank_id)->getPrice();
            $terug_aantal = $terug_aantal - $drankprijs;
            $geldService->geefGeldStukkenTerug($terug_aantal);
            unset($_SESSION["geldbuidel"]);
            $_SESSION["aankoop"] = $drank_id;
            header("location: drankautomaat.php");
        } catch (Exception $ex) {
            header("location: drankautomaat.php?error=drankkeuze");
        }
        break;
    
    case "plusdrank":
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false) {
            header("location: private.php");
        }
        $drankService = new DrankService();
        try {
            $drankService->plusDrank($_GET["id"], 1);
            header("location: private.php");
        } catch (Exception $ex) {
            header("location: private.php?error=dranknoplus");
        }
        break;
    
    case "mindrank":
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false) {
            header("location: private.php");
        }
        $drankService = new DrankService();
        try {
            $drankService->plusDrank($_GET["id"], -1);
            header("location: private.php");
        } catch (Exception $ex) {
            header("location: private.php?error=dranknomin");
        }
        break;
    
    case "plusgeldstuk":
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false) {
            header("location: private.php");
        }
        $geldService = new GeldService();
        try {
            $geldService->veranderGeldInLade($_GET["waarde"], 1);
            header("location: private.php");
        } catch (Exception $ex) {
            header("location: private.php?error=geldnoplus");
        }
        break;
    
    case "mingeldstuk":
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false) {
            header("location: private.php");
        }
        $geldService = new GeldService();
        try {
            $geldService->veranderGeldInLade($_GET["waarde"], -1);
            header("location: private.php");
        } catch (Exception $ex) {
            header("location: private.php?error=geldnomin");
        }
        break;
    
    default:
        //header("location: drankautomaat.php");
        header("location: javascript://history.go(-1)");
        break;
}