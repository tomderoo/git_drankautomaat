<!DOCTYPE HTML>
<html>
    <head>
        <meta charset=utf-8>
        <title>Drankautomaat</title>
        <style tye="text/css">
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                font-size: 16px;
            }
            
            a {
                text-decoration: none;
            }
            
            a:hover, a:active {
                text-decoration: underline;
            }
            
            header, article {
                width: 900px;
                margin: auto;
                overflow: auto;
            }
            
            header p {
                float: left;
                padding: 10px;
                background-color: #cc3;
                margin: 0;
                margin-right: 10px;
                border: 2px solid #442;
            }
            
            header p a {
                color: #442;
                font-weight: bold;
            }
            
            .one {
                clear: both;
                width: 450px;
                float: left;
                overflow: auto;
                
            }
            
            .two {
                width: 450px;
                float: left;
                overflow: auto;
                
            }
            
            table td {
                padding: 10px;
                text-align: right;
            }
            
            table thead td, table tbody td:first-child {
                font-weight: bold;
            }
            
            table td:nth-last-child(1), table td:nth-last-child(2) {
                text-align: center;
            }
            
            table thead td {
                background-color: #cc3;
                color: #442;
                border: 1px solid #442;
            }
            
            table tbody td {
                background-color: #ffe;
                border: 1px solid #ffcc33;
            }

            article#error {
                <?php
                if (isset($_GET["error"])) {
                    $error = $_GET["error"];
                    print("display: block;\n");
                    switch ($error) {
                        case "dranknoplus":
                            $errormsg = "aantal kon niet worden verhoogd!<br><br>(Dranksoort werd niet teruggevonden, of er werd getracht te verhogen boven het maximum aantal van 20.)";
                            break;
                        case "dranknomin":
                            $errormsg = "aantal kon niet worden verlaagd!<br><br>(Dranksoort werd niet teruggevonden, of er werd getracht te verlagen onder het minimum aantal van 0.)";
                            break;
                        case "geldnoplus":
                            $errormsg = "aantal kon niet worden verhoogd!<br><br>(Geldsoort werd niet teruggevonden, of er werd getracht te verhogen boven het maximum aantal van 200 geldstukken.)";
                            break;
                        case "geldnomin":
                            $errormsg = "aantal kon niet worden verhoogd!<br><br>(Geldsoort werd niet teruggevonden, of er werd getracht te verlagen onder het minimum aantal van 0 geldstukken.)";
                            break;
                        default:
                            header("location: private.php");
                    }
                } else {
                    print("display: none;\n");
                }
                ?>
                box-sizing: border-box;
                margin: auto;
                margin-top: 50px;
                background-color: #fcc;
                color: #900;
                border: 1px solid #900;
                font-size: 1.125em;
                padding: 10px 50px;
                text-align: center;
            }
            
            clear {
                clear: both;
            }
        </style>
    </head>

    <body>
        <header>
            <h1>Backend drankautomaat</h1>
            <p><a href="private.php?logout">Uitloggen</a></p>
            <p><a href="drankautomaat.php">Naar de drankautomaat</a></p>
        </header>
        
        <article>
            <div class="one">
                <h2>Drankvoorraad</h2>
                <table>
                    <thead>
                        <tr>
                            <td>Drank</td>
                            <td>Prijs</td>
                            <td>Aantal</td>
                            <td colspan="2">Actie</td>

                        </tr>
                    </thead>
                    <tbody>
                <?php
                    foreach ($drankVoorraad as $drankRij) {
                        print("<tr>");
                        print("<td>" . $drankRij->getName() . "</td>");
                        print("<td>&euro; " . number_format($drankRij->getPrice()/100, 2) . "</td>");
                        print("<td>" . $drankRij->getNumber() . " / 20</td>");
                        if ($drankRij->getNumber() < 20) {
                            print("<td><a href=\"process.php?act=plusdrank&id=" . $drankRij->getId() . "\"><img src=\"img/buttonplus.png\"></a>");
                        } else {
                            print("<td>&nbsp;</td>");
                        }
                        if ($drankRij->getNumber() > 0) {
                            print("<td><a href=\"process.php?act=mindrank&id=" . $drankRij->getId() . "\"><img src=\"img/buttonmin.png\"></a>");
                        } else {
                            print("<td>&nbsp;</td>");
                        }

                        print("</tr>");
                    }
                ?>
                    </tbody>
                </table>
            </div>

            <div class="two">
                <h2>Geldlade</h2>
                <table>
                    <thead>
                        <tr>
                            <td>Munt</td>
                            <td>Aantal stukken</td>
                            <td colspan="2">Actie</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totaalGeldlade = 0;
                            foreach($geldLade as $geldRij) {
                                $geldAantal = $geldRij->getAantal();
                                $geldRekenwaarde = $geldRij->getRekenWaarde();
                                $totaalGeldlade += ($geldAantal * $geldRekenwaarde);
                                print("<tr>");
                                print("<td>&euro; " . $geldRij->getGeldWaarde() . "</td>");
                                print("<td>" . $geldAantal . " / 200</td>");
                                if ($geldAantal < 200) {
                                    print("<td><a href=\"process.php?act=plusgeldstuk&waarde=" . $geldRekenwaarde . "\"><img src=\"img/buttonplus.png\"></a>");
                                } else {
                                    print("<td>&nbsp;</td>");
                                }
                                if ($geldAantal > 0) {
                                    print("<td><a href=\"process.php?act=mingeldstuk&waarde=" . $geldRekenwaarde . "\"><img src=\"img/buttonmin.png\"></a>");
                                } else {
                                    print("<td>&nbsp;</td>");
                                }

                                print("</tr>");
                            }
                            print("<tr><td colspan=\"4\">Totaal in geldlade: &euro; " . number_format($totaalGeldlade/100, 2) . "</td></tr>");
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
        
        <article id="error">
            <p>Fout: <?php print($errormsg); ?></p>
        </article>
        
        <?php
        include("src/resource/scripttimer.php");
        ?>
    </body>
</html>


