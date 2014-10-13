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
                clear: both;
            }
            
            header p {
                padding: 10px;
                background-color: #cc3;
                margin: 0;
                margin-right: 10px;
                border: 2px solid #442;
                float: left;
            }
            
            header p a {
                color: #442;
                font-weight: bold;
            }
            
            article div {
                width: 450px;
                margin-top: 100px;
                background-color: #ffe;
                border: 1px solid #ffcc33;
                padding: 10px;
            }
            
            clearfix {
                clear: both;
            }
        </style>
    </head>

    <body>
        <header>
            <h1>Backend drankautomaat</h1>
            <p><a href="drankautomaat.php">Naar de drankautomaat</a></p>
        </header>
        
        <article>
            <div>
            <form action="private.php" method="post">
                <input type="text" size="20" name="loginuser" placeholder="Gebruikersnaam" maxlength="15" required autofocus>
                <input type="password" size="20" name="loginpwd" placeholder="Paswoord" maxlength="15" required>
                <input type="submit" value="Aanmelden">
            </form>
            </div>
        </article>
        
        <?php
        include("src/resource/scripttimer.php");
        ?>
    </body>
</html>


