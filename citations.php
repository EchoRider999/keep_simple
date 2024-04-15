<?php

// Tableau contenant des citations philosophiques avec les auteurs
$citations = array(
    array(
        "citation" => "La vie est un mystère qu'il faut vivre, et non un problème à résoudre.",
        "auteur" => "Gandhi"
    ),
    array(
        "citation" => "La seule façon de faire du bon travail est d'aimer ce que vous faites. Si vous n'avez pas encore trouvé, continuez à chercher. Ne vous contentez pas. Comme pour tout ce qui concerne le cœur, vous saurez quand vous le trouverez.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "Soyez le changement que vous voulez voir dans le monde.",
        "auteur" => "Gandhi"
    ),
    array(
        "citation" => "La vraie mesure d'un homme n'est pas combien il s'enrichit, mais dans son intégrité et sa capacité à affecter positivement ceux qui l'entourent.",
        "auteur" => "Bob Marley"
    ),
    array(
        "citation" => "Innover, c'est dire non à 1000 choses.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "Votre temps est limité, ne le gaspillez pas en menant une existence qui n'est pas la vôtre.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "Si vous n'avez pas assez de passion pour être critique, alors ne vous attendez pas à ce que vous ayez assez de passion pour créer.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "Être le plus riche du cimetière n'a pas d'importance pour moi... Aller me coucher le soir en me disant que nous avons fait quelque chose de merveilleux... C'est ce qui compte pour moi.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "L'innovation distingue le leader de la foule.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "Je suis convaincu que la moitié de ce qui sépare les entrepreneurs à succès de ceux qui ne réussissent pas est la persévérance.",
        "auteur" => "Steve Jobs"
    ),
    array(
        "citation" => "On fait du sale, on nettoie après.",
        "auteur" => "Niska"
    ),
    array(
        "citation" => "Quand la vie te fait des couilles, fais des omelettes.",
        "auteur" => "Alpha Wann"
    ),
    array(
        "citation" => "N'ayez pas peur de la vie. Croyez que la vie vaut la peine d'être vécue et votre croyance aidera à créer le fait.",
        "auteur" => "William James"
    ),
    array(
        "citation" => "Le succès n'est pas la clé du bonheur. Le bonheur est la clé du succès. Si vous aimez ce que vous faites, vous réussirez.",
        "auteur" => "Albert Schweitzer"
    ),
    array(
        "citation" => "La vie est 10% ce qui vous arrive et 90% comment vous y répondez.",
        "auteur" => "Lou Holtz"
    ),
    array(
        "citation" => " Il y a deux façons de prendre la vie du bon côté : croire en tout ou douter de tout. Les deux nous évitent d'avoir à réfléchir.",
        "auteur" => "Alfred Korzybski"
    ),
);



// Choisir une citation aléatoire
$citation_aleatoire = $citations[array_rand($citations)];

// Afficher la citation avec les balises HTML
echo <<<HTML
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                            <p class="mb-0 small text-body-tertiary">“<em>{$citation_aleatoire['citation']}..</em>”</p>
                            </blockquote>
                            <figcaption class="blockquote-footer text-body-secondary">
                             <cite title="Source Title">{$citation_aleatoire['auteur']}</cite>
                            </figcaption>
                        </figure>
HTML;

?>
