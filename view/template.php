<?php


/* --------------------
    AFFICHAGE COMMUN
----------------------*/

// Afficher la page de base avec la partie commune statique

function printPage($dynamicTitle, $dynamicHtml)
{
    echo '<!DOCTYPE html>
            <html lang="fr">
            <head>
                 <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="https://benoit.bes-webdeveloper-seraing.be/crud-portfolio/public/css/style.css">
                   <!-- Police Poppins -->
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                   <!-- Police Great Vibes -->          
                <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
                 <!-- Police Playfair Display -->
                <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
                                           
                 <title>Portfolio - ' . $dynamicTitle . '</title>            
            </head>
          <body>
          <header>
          <h1 class="logo"><a href="?type=all&action=read">Mon Portfolio</a></h1>                
          <nav><ul>
                            <li><a href="?type=all&action=read">Accueil</a></li>
                            <li><a href="?type=works&action=read">Travaux</a></li>
                            <li><a href="?type=services&action=read">Services</a></li>
                            <li><a href="?type=contacts&action=read">Contacts</a></li>
                            <li><a href="?type=details&action=read">Mes coordonnées</a></li>';

    if (!isset($_COOKIE['token'])) {
        echo '<li><a href="login.php">Login</a></li>';
    } else {
        echo '<li><a href="logout.php">Logout</a></li>';
    }

    echo '</ul></nav><div class="clear"></div></header><section>' .
        $dynamicHtml .
        '</section><footer><p>© 2022 Copyright : <a href="mailto:fabienne-benoit@live.fr">fabienne-benoit@live.fr</a>
  </p>
</footer>
<script src="functions.js"></script>
</body>
</html>';
}



