<?php
header("Content-Type: application/json");


function filter_empty($item)
{
    return $item != "";
}

try {
    // utilisateur est un utilisateur avec tout les droits sur la base de données ChatDB
    $DB = new PDO("mysql:host=localhost;dbname=JobBoard", "visitor", "bddprojet");
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "message" => $e->getMessage()
    ]);
    exit();
}

$tab = array_filter(explode("/", $_SERVER['REQUEST_URI']), 'filter_empty'); // on récupère la route de l'url et on enlève les elements vides grace au filter
$tab = array_values($tab); // reset les clés du tableaux à leurs positions

if (count($tab) > 0) { // si on a au moins 1 élément on traite la requête
    $is_Api = $tab[0] == "api";
    $is_Connexion = $tab[1] == "connexion";
    if ($is_Api and $is_Connexion) { // si on fait bien une requête api et une connexion

        // le code qui permet de traiter les connexions
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        
        if (isset($mail) and isset($mdp)) {
            try {
                $request = "select mail, password, token, admin from peoples where mail = :mail;";
                $conn = $DB->prepare($request);
                $conn->bindValue(':mail', $mail, PDO::PARAM_STR);
                $conn->execute();
                $connected = $conn->fetch();
                if ($connected and password_verify($mdp, $connected['password'])) {
                    echo json_encode([
                        "success" => true,
                        "token" => $connected["token"],
                        "admin" => $connected["admin"],
                        "message" => "Connexion reussi"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Mauvaise identifiant"
                    ]);
                }
            } catch (Exception $ex) {
                echo json_encode(
                    array(
                    "success" => false,
                    "message" => $ex->getMessage()
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "success" => false,
                    "message" => "Il manque des informations"
                )
            );
        }

    } else { // si on a pas plus de parametre on traite ici
        echo json_encode([
            "success" => false,
            "message" => "Vous êtes pas aux bonne endroit."
        ]);
    }
}
?>