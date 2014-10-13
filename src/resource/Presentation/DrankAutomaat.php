<!DOCTYPE HTML>
<html>
    <head>
        <meta charset=utf-8>
        <title>Drankautomaat</title>
        <link href='http://fonts.googleapis.com/css?family=Cuprum:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href="css/gimmesoda.css" rel="stylesheet" type="text/css">
    </head>

    <body>
    <div id="wrapper">
        <div id="placeholder">[ Placeholder : <a href="private.php">To Admin</a> ]</div>
        
        <header>
            <div></div>
            <div></div>
            <div></div>
            <div><span class="shadow">gimme</span></div>
            <div>SODA</div>
        </header>

        <section id="drankruimte">
            <?php
            foreach ($drankLijst as $drank) {
                ?>
                <div class="drank">
                    <div class="geldwaardebutton">
                        <?php print($drank->getName()); ?> : &euro; <?php print(number_format($drank->getPrice()/100, 2)); ?>
                    </div>
                    <div <?php if($sessieSaldo < $drank->getPrice() or $drank->getNumber() == 0) { print("style=\"opacity:0.5;\" "); } ?>class="drankimage">
                        <img src="img/<?php print($drank->getImage()); ?>" alt="">
                    </div>
                    <?php
                    if ($drank->getNumber() > 0) {
                        if ($sessieSaldo >= $drank->getPrice()) {
                            ?>
                            <form action="process.php?act=kiesdrank&id=<?php print($drank->getId()); ?>" method="post">
                                <input type="submit" value="Kies">
                            </form>
                            <?php
                        } else {
                            ?>
                            <div class="moremoneybutton">
                                Saldo ontoereikend
                            </div>
                            <?php
                        }
                    ?>
                    <?php
                    } else {
                    ?>
                    <div class="unavailablebutton">
                        Niet beschikbaar
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
            } 
            
            ?>
            
        </section>
        
        <aside id="geldscherm">
            <div id="muntkeuze">
                <?php
                    foreach($geldlade as $geldRij) {
                        if($geldRij->getAantal() < 200) {
                        ?>
                        <form action="process.php?act=werpmunt" method="post">
                            <input type="hidden" name="munt" value="<?php print($geldRij->getRekenWaarde()); ?>">
                            <input type="image" src="img/stuk<?php print($geldRij->getRekenWaarde()); ?>.png" alt="<?php print($geldRij->getGeldWaarde()); ?>">
                        </form>
                        <?php
                        } else {
                            ?>
                            <div class="muntvol">
                                <img src="img/stuk<?php print($geldRij->getRekenWaarde()); ?>.png" alt="Munthouder vol, andere munt inwerpen..." title="Munthouder vol, andere munt inwerpen">
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
            
            <div id="geldsaldo" class="clear">
                <?php
                $geldbuidelsaldo = number_format($sessieSaldo/100, 2);
                ?>
                <p>&euro; <?php print($geldbuidelsaldo) ?></p>
                <?php
                if ($sessieSaldo > 0) {
                ?>
                <form action="process.php?act=geldterug" method="post"><input type="submit" value="Geld terug"></form>
                <?php
                }
                ?>
                <?php
                    if ($wisselgeldStatus == false) {
                        ?>
                        <p id="wisselwarning">Gelieve gepast geld te gebruiken, onvoldoende wisselgeld!</p>
                        <?php
                    }
                ?>
            </div>

        </aside>
        
        <?php
        $geldterugscherm = false;
        foreach($_SESSION["geldteruggave"] as $teruggavetest) {
            if ($teruggavetest > 0 or isset($_SESSION["geldteruggave"]["voldaan"])) {
                $geldterugscherm = true;
            }
        }
        ?>
            
        <?php
        if (isset($aangekochtedrank) or $geldterugscherm == true) {
            ?>
            <div id="overlay">
                
            </div>
            <div id="uithetbakje">
                <div id="hetfeitelijkebakje">
                    <div id="drankbakje">
                <?php
                if (isset($aangekochtedrank)) {
                    ?>
                    <img style="opacity:1;" src="img/<?php print($aangekochtedrank->getImage()); ?>">
                    <?php
                }
                ?>
                    </div>
                    <div id="geldbakje">
                <?php
                if ($geldterugscherm == true) {
                    $aantal_010 = $_SESSION["geldteruggave"]["stuk_010"];
                    $aantal_020 = $_SESSION["geldteruggave"]["stuk_020"];
                    $aantal_050 = $_SESSION["geldteruggave"]["stuk_050"];
                    $aantal_100 = $_SESSION["geldteruggave"]["stuk_100"];
                    $aantal_200 = $_SESSION["geldteruggave"]["stuk_200"];
                    while ($aantal_010 > 0) {
                        print("<img src=\"img/stuk10.png\" alt=\"&euro; 0.10\">");
                        $aantal_010--;
                    }
                    while ($aantal_020 > 0) {
                        print("<img src=\"img/stuk20.png\" alt=\"&euro; 0.20\">");
                        $aantal_020--;
                    }
                    while ($aantal_050 > 0) {
                        print("<img src=\"img/stuk50.png\" alt=\"&euro; 0.50\">");
                        $aantal_050--;
                    }
                    while ($aantal_100 > 0) {
                        print("<img src=\"img/stuk100.png\" alt=\"&euro; 1.00\">");
                        $aantal_100--;
                    }
                    while ($aantal_200 > 0) {
                        print("<img src=\"img/stuk200.png\" alt=\"&euro; 2.00\">");
                        $aantal_200--;
                    }
                    if(isset($_SESSION["geldteruggave"]["voldaan"]) && $_SESSION["geldteruggave"]["voldaan"] == 0) {
                        print("Onvoldoende wisselgeld...");
                    }
                    unset($_SESSION["geldteruggave"]);
                }
                ?>
                    </div>
                    <p><a href="drankautomaat.php">Sluiten</a></p>
                </div>
                
            </div>
            <?php
        }
        unset($aangekochtedrank);
        ?>
        
        <?php
        if (isset($_GET["error"]) && ($_GET["error"] == "muntinwerp" or $_GET["error"] == "drankkeuze")) {
            ?>
            <div id="overlay">
            </div>
            <div id="uithetbakje">
                <div id="hetfeitelijkebakje">
                    <div id="errormsg">
                        <?php if ($_GET["error"] == "muntinwerp") { print ("Muntinwerp mislukt!<br>Probeer opnieuw met een andere munt..."); } ?>
                        <?php if ($_GET["error"] == "drankkeuze") { print ("Drankkeuze mislukt!<br>Maak een nieuwe keuze..."); } ?>
                    </div>
                    <p><a href="drankautomaat.php">Sluiten</a></p>
                </div>
            </div>
            <?php
        }
        ?>
        
        <?php
        include("src/resource/scripttimer.php");
        ?>
    </div>
    </body>
</html>


