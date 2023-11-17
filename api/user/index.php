<?php
header("Content-Type: application/json");

$token = $_COOKIE['token'];

if ($token) {
    $method = $_SERVER['REQUEST_METHOD'];

    try {
        // utilisateur est un utilisateur avec tout les droits sur la base de données ChatDB
        $DB = new PDO("mysql:host=localhost;dbname=JobBoard", "admin", "bddprojet");
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            "message" => $e->getMessage()
        ]);
        exit();
    }

    switch ($method) {
        case 'GET': // On gère l'inscription d'un utilisateur
            // on verifie s'il le token envoyé est valide
            try {
                $request = "select name, prenom, mail, telephone from peoples where token = :token;";
                $conn = $DB->prepare($request);
                $conn->bindValue(':token', $token, PDO::PARAM_STR);
                $conn->execute();
                $user = $conn->fetch();
                if ($user) {
                    echo json_encode([
                        "success" => true,
                        "user" => $user
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "token" => $token,
                        "message" => "L'utilisateur n'existe pas."
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
            break;
        case 'DELETE':

            // on verifie s'il le token envoyé est valide
            try {
                $request = "delete from peoples where token = :token;";
                $conn = $DB->prepare($request);
                $conn->bindValue(':token', $token, PDO::PARAM_STR);
                $conn->execute();

                echo json_encode([
                    "success" => true,
                    "message" => "L'utilisateur à été supprimé avec succès"
                ]);
            } catch (Exception $ex) {
                echo json_encode(
                    array(
                        "success" => false,
                        "message" => $ex->getMessage()
                    )
                );
            }
            break;
        case 'PUT':
            $myEntireBody = json_decode(file_get_contents('php://input'));

            $name = $myEntireBody->{"name"};
            $surname = $myEntireBody->{"surname"};
            $mail = $myEntireBody->{"mail"};
            $phone = $myEntireBody->{"phone"};
            $old_password = $myEntireBody->{"old_password"};
            $new_password = $myEntireBody->{"new_password"};

            $params = [];

            if (isset($name) and !empty($name)) {
                array_push($params, "name");
            }
            if (isset($surname) and !empty($surname)) {
                array_push($params, "prenom");
            }
            if (isset($mail) and !empty($mail)) {
                array_push($params, "mail");
            }
            if (isset($phone) and !empty($phone)) {
                array_push($params, "telephone");
            }

            if (isset($old_password) and isset($new_password) and !empty($old_password) and !empty($new_password)) {
                // on change le mot de passe d'abord s'il existe
                try {
                    $request = "select password from peoples where token = :token";
                    $conn = $DB->prepare($request);
                    $conn->bindValue(':token', $token, PDO::PARAM_STR);
                    $conn->execute();
                    $connected = $conn->fetch();
                    if ($connected and password_verify($old_password, $connected['password'])) {
                        array_push($params, "password");
                    } else {
                        echo json_encode([
                            "success" => false,
                            "message" => "l'ancien mot de passe n'est pas correcte"
                        ]);
                        exit(); // on exit pour pas executer le reste
                    }
                } catch (Exception $ex) {
                    echo json_encode([
                        'success' => false,
                        'erreur' => $e->getMessage()
                    ]);
                }
            }

            if (count($params)) {
                $setters = "";
                foreach ($params as $key => $value) {
                    $setters .= " " . $value . " = :" . $value . ",";
                }
                $setters = substr($setters, 0, -1);
                $request = "update peoples set " . $setters . " where token = :token;";

                try {
                    $conn = $DB->prepare($request);
                    if (isset($name) and !empty($name)) {
                        $conn->bindValue(':name', $name, PDO::PARAM_STR);
                    }
                    if (isset($mail) and !empty($mail)) {
                        $conn->bindValue(':mail', $mail, PDO::PARAM_STR);
                    }
                    if (isset($phone) and !empty($phone)) {
                        $conn->bindValue(':telephone', $phone, PDO::PARAM_STR);
                    }
                    if (isset($surname) and !empty(trim($surname))) {
                        $conn->bindValue(':prenom', $surname, PDO::PARAM_STR);
                    }
                    if (isset($new_password) and !empty(trim($new_password))) {
                        $conn->bindValue(':password', password_hash($new_password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                    }
                    $conn->bindValue(':token', $token, PDO::PARAM_STR);

                    $conn->execute();
                    echo json_encode([
                        'success' => true,
                        'message' => "profil mis à jours"
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'erreur' => $e->getMessage()
                    ]);
                }


            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Aucune données fournises"
                ]);
            }


            break;
    }

} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Vous etes pas connecté."
        )
    );
}
?>