<?php
// Vérifie si l'utilisateur est connecté
session_start();

// Déconnexion
if(isset($_GET['deco'])) session_unset();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
    // Redirection vers la page de connexion
    header("Location: index.php");
    exit(); // Assure que le code s'arrête ici pour éviter l'affichage de la page actuelle
}

// Définition de la clé de chiffrement
include 'config/encryption_key.php';

// On enregistre l'identifiant
$identifiant = $_SESSION["identifiant"]; 

// Vérifier si le nom du fichier existe sinon le créer en session
$_SESSION['my_json'] ?? $_SESSION['my_json'] = "json/".$identifiant .".json";

// Définition du nom du fichier json contenant les notes
$my_json = $_SESSION['my_json'];


// Fonction pour déchiffrer et charger les notes depuis le fichier JSON
function chargerNotes() {
    global $my_json, $encryption_key;
    $encrypted_data = file_exists($my_json) ? file_get_contents($my_json) : '';
    $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, substr($encryption_key, 0, 16));
    return json_decode($decrypted_data, true) ?: [];
}

// Fonction pour chiffrer et sauvegarder les notes dans le fichier JSON
function sauvegarderNotes($notes) {
    global $my_json, $encryption_key;
    $json_data = json_encode($notes, JSON_PRETTY_PRINT);
    $encrypted_data = openssl_encrypt($json_data, 'aes-256-cbc', $encryption_key, 0, substr($encryption_key, 0, 16));
    file_put_contents($my_json, $encrypted_data);
}

// Chargement des notes existantes
$notes = chargerNotes();

// Ajouter une note
if (isset($_POST['ajouter'])) {
    $notes[] = ['contenu' => $_POST['contenu']];
    sauvegarderNotes($notes);
}

// Modifier une note
if (isset($_POST['modifier'])) {
    $notes[$_POST['index']] = ['contenu' => $_POST['contenu']];
    sauvegarderNotes($notes);
}

// Supprimer une note
if (isset($_POST['supprimer'])) {
    unset($notes[$_POST['index']]);
    $notes = array_values($notes);
    sauvegarderNotes($notes);
}

// Tableau des thèmes Bootswatch - https://bootswatch.com/ - prefs :  solar cyborg superhero darkly vapor
$themes = ["solar","cyborg","darkly","slate","superhero","vapor","quartz","cerulean","cosmo","flatly","journal","litera","lumen","lux","materia","minty","morph","pulse","sandstone","simplex","sketchy","spacelab","united","yeti","zephyr"];

// Theme de la session sinon par défaut
$my_theme = $_SESSION["theme"] ?? 'solar'; 

// Si choix du theme
if (isset($_POST['t']) && in_array($_POST['t'], $themes)) {
    $my_theme = $_POST['t'];
    $_SESSION["theme"] = $my_theme;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keep</title>
    <link rel="icon" href="img/logo.jpg" />
    <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/<?php echo $my_theme; ?>/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><small>📝</small><a href="./" class="text-decoration-none">Keep</a> - <?php echo $identifiant; ?></h1>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <!-- Formulaire pour ajouter ou modifier une note -->
                <form method="post">
                    <div class="input-group mb-3">
                        <?php if (isset($_POST['a_modifier'])) : ?>
                            <input type="hidden" name="index" value="<?php echo $_POST['index']; ?>">
                        <?php endif; ?>
                        <input type="text" class="form-control" name="contenu" value="<?php echo isset($_POST['a_modifier']) ? $notes[$_POST['index']]['contenu'] : ''; ?>" required="required" placeholder="Entrez une nouvelle note" required>
                        <?php if (isset($_POST['a_modifier'])) : ?>
                            <input class="btn btn-primary" type="submit" name="modifier" value="Modifier">
                        <?php else : ?>
                            <input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter">
                        <?php endif; ?>
                    </div>
                </form>
                <ul class="list-group">
                    <?php 
                    // Tri des clés dans l'ordre décroissant
                    krsort($notes);
                    $my_index = isset($_POST['index']) ? $_POST['index'] : null;

                    foreach ($notes as $index => $note) {
                        if ((string)$my_index === (string)$index) {
                            $my_active = "active";
                        } else {
                            $my_active = "";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action <?php echo $my_active; ?>">
                        <form method="post" action="">
                            <?php echo $note['contenu']; ?>
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" class="btn btn-sm float-end" name="supprimer" value="🗑️">
                            <input type="submit" class="btn btn-sm float-end" name="a_modifier" value="✏️">
                        </form>
                    </li>
                    <?php 
                    } // foreach note
                    ?>
                </ul>
                <br>
                <footer class="text-center">
                    <div class="text-center p-3">
                        <form method="post">
                            <a title="GitHub Project page" target="_blank" class="text-body text-decoration-none" href="https://github.com/EchoRider999/keep_simple">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 16 16" width="20" aria-hidden="true"><path fill="currentColor" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg>
                            </a>
                            &nbsp;
                            <select title="Changer le thème" name="t" class="btn btn-sm btn-outline-secondary" onchange="this.form.submit()">
                                <?php
                                foreach ($themes as $theme) {
                                ?>
                                <option value="<?php echo $theme;?>" <?php if ($my_theme==$theme){ echo "selected";}?> ><?php echo $theme; ?></option>
                                <?php
                                } // forearch theme
                                ?>
                            </select>
                            &nbsp;
                            <a title="Déconnexion" class="text-body text-decoration-none" href="?deco">
                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 27.000000 27.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,27.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none"><path d="M22 248 c-18 -18 -16 -68 3 -68 9 0 15 9 15 25 0 25 0 25 95 25 l95
                                0 0 -95 0 -95 -95 0 c-95 0 -95 0 -95 25 0 16 -6 25 -15 25 -19 0 -20 -53 -1 -69 9 -8 51 -11 122 -9 l109 3 0 120 0 120 -110 3 c-77 2 -114 -1 -123 -10z"/> <path d="M117 193 c-4 -3 0 -15 10 -25 15 -17 13 -18 -50 -18 -53 0 -67 -3 -67 -15 0 -12 14 -15 67 -15 64 0 66 -1 49 -19 -32 -35 4 -35 40 0 l34 33 -32 33 c-33 34 -40 38 -51 26z"/> </g> </svg>
                            </a>
                        </form>
                    </div> <!-- text-center p-3 -->
                    <?php file_exists('citations.php') ? include 'citations.php' : ''; ?>
                </footer>
            </div> <!-- col-md-6 offset-md-3 -->
        </div> <!-- row mt-4 -->
    </div> <!-- container mt-5 -->
</body>
</html>