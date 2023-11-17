<?php
header("Content-Type: application/json");


function filter_empty($item)
{
    return $item != "";
}

try {
    // utilisateur est un utilisateur avec tout les droits sur la base de données ChatDB
    $DB = new PDO("mysql:host=localhost;dbname=JobBoard", "phpmyadmin", "bddprojet");
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "message"=>$e->getMessage()
    ]);
    exit();
}

$tab = array_filter(explode("/", $_SERVER['REQUEST_URI']), 'filter_empty'); // on récupère la route de l'url et on enlève les elements vides grace au filter
$tab = array_values($tab); // reset les clés du tableaux à leurs positions

if (count($tab) > 0) { // si on a au moins 1 élément on traite la requête
    $is_Api = $tab[0] == "api";
    $is_Connexion = $tab[1] == "inscription";
    if ($is_Api and $is_Connexion) { // si on fait bien une requête api et une inscription
        
        // le code qui permet de traiter les inscriptions
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        $name = $_POST['name'];
        
        if (isset($mail) and isset($mdp) and isset($name)){
            $token = bin2hex(random_bytes(64));
            try{
                $request = "insert into peoples(`mail`, `name`, `password`, `token`) values (:mail, :name, :password, :token);";
                $conn = $DB->prepare($request);
                $conn->bindValue(':mail', $mail, PDO::PARAM_STR);
                $conn->bindValue(':name', $name, PDO::PARAM_STR);
                $conn->bindValue(':password', password_hash($mdp, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $conn->bindValue(':token', $token, PDO::PARAM_STR);
                $conn->execute();

                echo json_encode([
                    "success" => true,
                    "message" => "Compte cree avec succes"
                ]);
            }
            catch (Exception $ex) {
                if ($ex->errorInfo[1] == 1062) {
                    echo json_encode(array(
                            "success" => false,
                        "message" => "Cette adresse mail est déjà utilisé"
                    ));
                 } else {
                    echo json_encode(array(
                            "success" => false,
                        "message" => $ex->getMessage()
                    ));
                 }
            }
        } else {
            echo json_encode(array(
                    "success" => false,
                "message" => "Il manque des informations"
            ));
        }
        
    } else { // si on a pas plus de parametre on traite ici
        echo json_encode([
            "success" => false,
            "erreur"=>"Vous êtes pas aux bonne endroit."
        ]);
    }
}
?>