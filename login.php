<?php

require_once './view/template.php';
require_once './model/connect.php';
require_once './model/usersManager.php';

// Si l'utilisateur n'est pas connecté, on affiche le formulaire de connexion

if (testLogin() == false) {
    $title = 'Login';
    $html = getLoginForm();
    printPage($title, $html);
}

// testLogin() : Si le formulaire a été soumis et que tout est correct, logUSer avec setcookie 'token'

function testLogin(): bool {
    if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['username'], $_POST['password'])
        && !empty($_POST['username']) && !empty($_POST['password'])) {

        // On récupère les utilisateurs de la base de données

        $users = getUsers();

        // On vérifie si le username entré dans le formulaire est bien dans la base de données
        // S'il est trouvé, retournera l'index, sinon, renverra false

        $key = array_search($_POST['username'], array_column($users, 'user_name'));
        if ($key !== false && isset($users[$key])) {
            $user = $users[$key];

            // Si l'utilisateur existe, on vérifie que le mot de passe correspond

            if ($user && $user['user_password'] === hash('sha512', $_POST['password'])) {

                // On récupère le token de l'utilisateur

                $row = getToken($_POST['username']); // Récupérer la ligne avec key => value
                $token = $row['user_token']; // Récupérer la valeur du token

                // set cookie avec le token, 60 * 60 * 3 fera expirer le cookie après 3h

                setcookie('token', $token, time() + (60 * 60 * 3), '/', $_SERVER['REMOTE_HOST'], true, false);
                header('Location: index.php');
            }else{
                echo '<p class="alert_message">Le mot de passe est incorrect.<br></p>';
            }
            return false;
        }else {
            echo '<p class="alert_message">Le nom d\'utilisateur n\'existe pas.<br></p>';
        }
        return false;
    }
    return false;
}

/*
  hash(
    string $algo,
    string $data,
    bool $binary = false,
    array $options = []
): string
*/

// Formulaire pour se connecter à l'API

function getLoginForm(): string {
    $form = '<h1>Formulaire de connexion</h1><div class="form-container"><form method="post" class="login-form">
       <div>
           <label for="username">Nom d\'utilisateur :</label>
           <input type="text" name="username" id="username" placeholder="Username" required maxlength="45"> 
      </div>         
      <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" placeholder="Password" required minlength="8" maxlength="30">    
      </div>           
      <div>
             <button type="submit">Se connecter</button>
      </div>
    </form>';

    return $form;
}