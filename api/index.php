<?php
header("Content-Type: application/json");
require('db_request.php');
require('db_request_with_id.php');

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
    if ($is_Api and count($tab) > 1) { // si on fait bien une requête api et si on a un autre élément
        $type = $tab[1]; // on récupère le nom de la table s'il est passé dans l'url sinon il est null
        $id = $tab[2]; // on récupère l'id si il est passé dans l'url sinon il est null
        if (isset($id) and is_numeric($id)) { // si on a un id on le converti en entier 
            $id = intval($id);
        }

        switch ($type) {
            case 'advertisements':
                if (isset($id)) {
                    echo json_encode(get_advertisements_with_id($DB, $id));
                } else {
                    echo json_encode(get_advertisements($DB));
                }
                break;
            case 'companies':
                if (isset($id)) {
                    echo json_encode(get_companies_with_id($DB, $id));
                } else {
                    echo json_encode(get_companies($DB));
                }
                break;
            case 'peoples':
                if (isset($id)) {
                    echo json_encode(get_peoples_with_id($DB, $id));
                } else {
                    echo json_encode(get_peoples($DB));
                }
                break;
            case 'peoples_advertisements':
                echo json_encode(get_peoples_advertisements($DB));
                break;
            default:
                echo "vous êtes perdu";
                break;
        }
    } else { // si on a pas plus de parametre on traite ici
        echo json_encode([
            "peoples" => get_peoples($DB),
            "companies" => get_companies($DB),
            "advertisements" => get_advertisements($DB)
        ]);
    }
}
?>