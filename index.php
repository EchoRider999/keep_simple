<?php
// Démarrage de la session
session_start();

// Définition des identifiants valides
include 'config/users.php';

$page_protegee = "keep.php";

// Définition du nombre maximum de tentatives de connexion
$nombre_max_tentatives = 3;

// Définition des erreurs
$errors = [];

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    header("Location: $page_protegee");
    exit();
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des identifiants
    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $_SESSION['identifiant'] = $identifiant;
    
    // Vérification si les identifiants sont valides
    if (isset($identifiants_valides[$identifiant]) && $identifiants_valides[$identifiant] === $mot_de_passe) {
        $_SESSION['connecte'] = true;
        header("Location: $page_protegee");
        exit();
    } else {
        $errors[] = "🔐 Erreur d'identification !";

        // Incrémentation du compteur de tentatives de connexion
        if(!isset($_SESSION['tentatives'])) {
            $_SESSION['tentatives'] = 1;
        } else {
            $_SESSION['tentatives']++;
        }
        
        // Si le nombre maximum de tentatives est dépassé, affichage du captcha
        if($_SESSION['tentatives'] >= $nombre_max_tentatives) {
            // Vérification du captcha
            $captcha = $_POST['captcha'] ?? ''; 
            if(!isset($_SESSION['captcha']) || $captcha !== $_SESSION['captcha']) {
                $errors[] = "😶‍  Captcha incorrect !";
            }
        }
    }
}

// Génération du captcha si nécessaire
if(!isset($_SESSION['captcha']) || !isset($_SESSION['tentatives']) || $_SESSION['tentatives'] >= $nombre_max_tentatives) {
    $_SESSION['captcha'] = substr(md5(rand()), 0, 3);
}

$captcha = $_SESSION['captcha'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Keep</title>
    <link rel="icon" href="logo.jpg" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="flex justify-center items-center py-20">
        <div class="bg-gray-800 p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold text-center mb-4">Keep</h2>
                <?php if (!empty($errors)): ?>
                    <div class="bg-red-800 border border-red-500 text-white p-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <span onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3 closealert">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 01.706.706L10.707 10l4.347 4.348a.5.5 0 11-.707.706L10 10.707l-4.348 4.347a.5.5 0 11-.706-.707L9.293 10 4.645 5.652a.5.5 0 01.707-.706L10 9.293l4.348-4.347z"/></svg>
                        </span>
                    </div>
                <?php endif; ?>
            <form method="post" action >
                <div class="mb-4">
                    <label for="identifiant" class="block">Identifiant:</label>
                    <input type="text" id="identifiant" name="identifiant" class="w-full rounded-md bg-gray-700 border-none px-4 py-2">
                </div>
                <div class="mb-4">
                    <label for="mot_de_passe" class="block">Mot de passe:</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="w-full rounded-md bg-gray-700 border-none px-4 py-2">
                </div>
                <?php if(isset($_SESSION['tentatives']) && $_SESSION['tentatives'] >= 3): ?>
                <div class="mb-4">
                    <label for="captcha" class="block">Captcha</label>
                    <input type="text" class="w-full rounded-md bg-gray-700 border-none px-4 py-2" id="captcha" name="captcha" placeholder="<?php echo $captcha; ?>">
                </div>
                <?php endif; ?>
                <button type="submit" class="w-full bg-blue-500 text-white font-bold px-4 py-2 rounded-md">Se connecter</button>
            </form>
            <footer class="rounded-lg shadow m-4">
                <div class="w-full px-4 py-2">
                    <span class="block text-sm text-center">
                        <a title="GitHub Project page" target="_blank" href="https://github.com/EchoRider999/keep_simple">
                            <svg style="display:inherit;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" xml:space="preserve" version="1.1" viewBox="0 0 20 20">
                                <image width="20" height="20" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAA3XQAAN10BGYBGXQAAAfRJREFUOMuVlT1rVFEQhp97E80SsoWNqIn+AYsUmibarUSx0yBWomJpYaOFFunWxtIunSQgNqaL/gFRMBhEEWRt8oEGFSOoZE3iPhbOXU42N5J94XDnzJ33PcOcuXMzEqiFWQGOA2eAEeBA+FeAl8BTYA5oAmRZxjaoqJl6TJ1Sv6gtt6MV76YiNksS2SLWo15SF909FoLT0xYNMdQr6moXYgVWg/uvZGGMqssRMKfejeemuqH+VH+E/Uedj5hnwVlWTxSCVXUmObEehxxUL6vjETyqnlOvqoMRczvhzagDvUAtVic+ZVn2oMSfdkN6vTXgVA6MA9VwbgJL7B5LwHrYVWActZGkPa/u39YGO2Sp7lOfJ/xGDgwlce+Br11kuAq8S/ZDOdCXHtyFWBmnLwfWEscg0N+FWAU4nOzXcmAxcRwFhosa/a9+nfGBBdTJjs6fVY+0O79ELNYh9XEHdxL1tPpd/aDeVz+qr9Qb6ojal4jsjYFwXX3h1uHxTR1DrajTalO9o16LT031iTqQCPaXZFVgSq0UgcOR4Wf1pHpevafWErFi1UvEGqFBHqV5DdwEWkAd+A08Ahold9Ls2K8At0JjS6Ez9az6Vl1Xf6kTJRlOJJm9CU57yObQHuECs8AF4CHQC+zZoXM2gGngYnAsfgN/AdfO+PhnKC6aAAAAAElFTkSuQmCC"/>
                            </svg>
                        </a>
                    </span>
                </div>
            </footer>
            <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/slate/bootstrap.min.css" rel="stylesheet">
            <?php file_exists('citations.php') ? include 'citations.php' : ''; ?>
        </div> <!-- bg-gray-800 p-8 rounded-lg shadow-md w-96 -->
    </div> <!-- flex justify-center items-center py-40 -->
    <script>
        // Fermeture du message d'erreur
        document.addEventListener('DOMContentLoaded', function () {
            var closealert = document.querySelectorAll('.closealert');
            closealert.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    var parent = e.target.parentNode;
                    parent.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>
