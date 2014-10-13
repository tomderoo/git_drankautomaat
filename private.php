<?php

use resource\Service\DrankService;
use resource\Service\GeldService;
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("resource", "src");
$classLoader->register();

session_start();
if (!isset($_SESSION["login"]) or (isset($_GET["logout"]))) {
    $_SESSION["login"] = false;
}

if (isset($_POST["loginpwd"]) && $_POST["loginpwd"] == "gimmesoda" && isset($_POST["loginuser"]) && $_POST["loginuser"] == "gimmesoda") {
    $_SESSION["login"] = true;
}

if ($_SESSION["login"] == false) {
    include('src/resource/Presentation/Login.php');
} elseif ($_SESSION["login"] == true) {
    $drankService = new DrankService();
    
    $drankVoorraad = $drankService->getDrankOverzicht();
    
    $geldService = new GeldService();
    
    $geldLade = $geldService->getGeldlade();
    
    include('src/resource/Presentation/Backend.php');
}