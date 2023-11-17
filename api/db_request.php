<?php
    function get_companies($DB){
        $datas = [];
        try {
            $conn = $DB->query("select id, name, description from companies;");
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                array_push($datas, [
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "description" => $row["description"]
                ]);
            }
        } catch (Exception $ex) {
            
        }
        return $datas;
    }

    function get_advertisements($DB){
        $datas = [];
        try {
            $conn = $DB->query("select id, name, message, id_companie from advertisements;");
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                array_push($datas, [
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "message" => $row["message"],
                    "id_companie" => $row["id_companie"]
                ]);
            }
        } catch (Exception $ex) {
            
        }
        return $datas;
    }

    function get_peoples($DB){
        $datas = [];
        try {
            $conn = $DB->query("select id, name, prenom, mail, telephone, password, token, admin from peoples;");
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                array_push($datas, $row);
            }
        } catch (Exception $ex) {
            
        }
        return $datas;
    }

    function get_peoples_advertisements($DB){
        $datas = [];
        try {
            $conn = $DB->query("select id_people, id_advertissements from peoples_advertissements;");
            $all_datas = $conn->fetchAll();
            foreach ($all_datas as $row) {
                array_push($datas, $row);
            }
        } catch (Exception $ex) {
            
        }
        return $datas;
    }
?>