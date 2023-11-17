<?php
    function get_companies_with_id($DB, $id){
        $data = null;
        try {
            $conn = $DB->prepare("select id, name, description from companies where id = :id;");
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            $conn->execute();
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                $data = json_encode($row);
            }
        } catch (Exception $ex) {
            
        }
        return $data;
    }

    function get_advertisements_with_id($DB, $id){
        $data = null;
        try {
            $conn = $DB->prepare("select id, name, message,date_debut,salaire, ville, type_de_poste, id_companie from advertisements where id = :id;");
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            $conn->execute();
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                $data = json_encode($row);
            }
        } catch (Exception $ex) {
            
        }
        return $data;
    }

    function get_peoples_with_id($DB, $id){
        $data = null;
        try {
            $conn = $DB->prepare("select id, name from peoples where id = :id;");
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            $conn->execute();
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                $data = json_encode([
                    "id" => $row["id"],
                    "name" => $row["name"]
                ]);
            }
        } catch (Exception $ex) {
            
        }
        return $data;
    }
?>