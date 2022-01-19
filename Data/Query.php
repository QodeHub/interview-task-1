<?php


include_once 'Config.php';

class Query extends Config
{
    protected static $table = "short_urls";

//    check if url exists in database
    public function urlExistsInDB($url){
        $query = "SELECT short_code FROM ".self::$table." WHERE original_url = :original_url LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $params = array(
            "original_url" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result["short_code"];
    }

//    insert url into database
    public function insertUrlInDB($url, $code){
        $query = "INSERT INTO ".self::$table." (original_url, short_code, created) VALUES (:original_url, :short_code, :timestamp)";
        $stmnt = $this->conn->prepare($query);
        $params = array(
            "original_url" => $url,
            "short_code" => $code,
            "timestamp" => date("Y-m-d H:i:s")
        );
        $stmnt->execute($params);

        return $this->conn->lastInsertId();
    }

//    get url from db if exists
    public function getUrlFromDB($code){
        $query = "SELECT id, original_url FROM ".self::$table." WHERE short_code = :short_code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $params=array(
            "short_code" => $code
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }

//    no of times url has been converted
    protected function incrementCounter($id){
        $query = "UPDATE ".self::$table." SET hits = hits + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }
}