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
    // Si le nombre maximum de tentatives est dépassé, affichage du captcha
    if(isset($_SESSION['tentatives']) && $_SESSION['tentatives'] >= $nombre_max_tentatives) {
        // Vérification du captcha
        $captcha = $_POST['captcha'] ?? ''; 
        if($captcha !== $_SESSION['captcha']) {
            $errors[] = "🔐 Erreur d'identification !";
            $errors[] = "😶‍  Captcha incorrect !";
        } else {
            // Vérification des identifiants si le captcha est correct
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
            }
        }
    } else {
        // Vérification des identifiants si le nombre maximum de tentatives n'est pas dépassé
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Keep</title>
    <link rel="icon" href="img/logo.jpg" />
    <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/slate/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary">
    <div class="container-fluid d-flex justify-content-center align-items-center py-5">
        <div class="p-3 rounded shadow-lg" style="max-width: 400px; width: 90%;">
            <h2 class="text-center mb-3"><small>📝</small> <a href="./" class="text-decoration-none">Keep</a></h2>
            <?php if (!empty($errors)): ?>
                <div class="alert p-2 shadow alert-dismissible alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <?php echo $error; ?><br/>
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form method="post" action>
                <div class="mb-3">
                    <label for="identifiant" class="form-label">Identifiant:</label>
                    <input type="text" id="identifiant" name="identifiant" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe:</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
                </div>
                <?php if(isset($_SESSION['tentatives']) && $_SESSION['tentatives'] >= 3): ?>
                <div class="mb-3">
                    <label for="captcha" class="form-label">Captcha</label>
                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="<?php echo $captcha; ?>">
                </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-success w-100">Se connecter</button>
            </form>
            <footer class="rounded shadow mt-4 text-center">
                <div class="p-2">
                    <a title="GitHub Project page" target="_blank" href="https://github.com/EchoRider999/keep_simple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </a>
                </div>
            </footer>
            <?php file_exists('citations.php') ? include 'citations.php' : ''; ?>
        </div>
    </div>
    <script>
        // Fermeture du message d'erreur
        document.addEventListener('DOMContentLoaded', function () {
            var closealert = document.querySelectorAll('.btn-close');
            closealert.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    var parent = e.target.parentNode.parentNode;
                    parent.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>

