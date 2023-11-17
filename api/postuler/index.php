<?php
header("Content-Type: application/json");

$token = $_COOKIE['token'];

if ($token) {
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

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id_annonce = $_GET["id"];
            if (isset($id_annonce) and is_numeric($id_annonce)) {
                $conn = $DB->prepare("select id from peoples where token = :token;");
                $conn->bindValue(':token', $token, PDO::PARAM_INT);
                $conn->execute();
                $user = $conn->fetch();
                $user_id = null;
                if ($user) {
                    $user_id = $user['id'];
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Vous existez pas, essayé de vous reconnecter"
                    ]);
                    exit();
                }

                try {
                    $request = "select id_people, id_advertissements from peoples_advertissements where id_people = :id_people and id_advertissements = :id_advertissements";
                    $conn = $DB->prepare($request);
                    $conn->bindValue(':id_people', $user_id, PDO::PARAM_INT);
                    $conn->bindValue(':id_advertissements', $id_annonce, PDO::PARAM_INT);
                    $conn->execute();
                    $data = $conn->fetch();
                    if (isset($data) and $data != false) {
                        echo json_encode([
                            "success" => true,
                            "data" => $data
                        ]);
                    } else {
                        echo json_encode([
                            "success" => false,
                            "message" => "Vous avez pas postuler pour ce poste"
                        ]);
                    }
                } catch (Exception $ex) {
                    if ($ex->errorInfo[1] == 1062) {
                        echo json_encode(
                            array(
                                "success" => false,
                                "message" => "Vous avez deja postuler pour cette offre"
                            )
                        );
                    } else {
                        echo json_encode([
                            "success" => false,
                            "erreur" => $ex->getMessage()
                        ]);
                    }
                }
            } else {
                echo json_encode(
                    array(
                        "success" => false,
                        "message" => "L'id n'est pas correcte."
                    )
                );
            }
            break;
        case 'POST':
            $id_annonce = $_POST["id"];
            if (isset($id_annonce) and is_numeric($id_annonce)) {
                $conn = $DB->prepare("select id from peoples where token = :token;");
                $conn->bindValue(':token', $token, PDO::PARAM_INT);
                $conn->execute();
                $user = $conn->fetch();
                $user_id = null;
                if ($user) {
                    $user_id = $user['id'];
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Vous existez pas, essayé de vous reconnecter"
                    ]);
                    exit();
                }

                try {

                    $request = "insert into peoples_advertissements(id_people, id_advertissements) values (:id_people, :id_advertissements)";
                    $conn = $DB->prepare($request);
                    $conn->bindValue(':id_people', $user_id, PDO::PARAM_INT);
                    $conn->bindValue(':id_advertissements', $id_annonce, PDO::PARAM_INT);
                    $conn->execute();
                    echo json_encode([
                        "success" => true,
                        "message" => "Vous avez bien postuler"
                    ]);
                } catch (Exception $ex) {
                    if ($ex->errorInfo[1] == 1062) {
                        echo json_encode(
                            array(
                                "success" => false,
                                "message" => "Vous avez deja postuler pour cette offre"
                            )
                        );
                    } else {
                        echo json_encode([
                            "success" => false,
                            "erreur" => $ex->getMessage()
                        ]);
                    }
                }
            } else {
                echo json_encode(
                    array(
                        "success" => false,
                        "message" => "L'id n'est pas correcte."
                    )
                );
            }
            break;
        case 'DELETE':
            $myEntireBody = json_decode(file_get_contents('php://input'));
            $id_annonce = $myEntireBody->id;

            $conn = $DB->prepare("select id from peoples where token = :token;");
            $conn->bindValue(':token', $token, PDO::PARAM_INT);
            $conn->execute();
            $user = $conn->fetch();
            $user_id = null;
            if ($user) {
                $user_id = $user['id'];
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Vous existez pas, essayé de vous reconnecter"
                ]);
                exit();
            }

            if (isset($id_annonce) && isset($user_id)) {
                try {
                    $request = "delete from peoples_advertissements where id_people = :id_people and id_advertissements = :id_advertissements;";
                    $conn = $DB->prepare($request);
                    $conn->bindValue(":id_people", $user_id, PDO::PARAM_STR);
                    $conn->bindValue(":id_advertissements", $id_annonce, PDO::PARAM_STR);
                    $conn->execute();
                    echo json_encode([
                        "success"=>true,
                        "message"=> "Vous avez bien annulé la condidature"
                    ]);
                } catch (Exception $ex) {
                    echo json_encode([
                        "success"=>false,
                        "erreur"=> $ex->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Oops, quelque chose c'est mal passé"
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