<?php
class Cellen {
    private $dbconn;
    private $table = "cel";

    public function __construct($dbconn) {
        $this->conn = $dbconn;
    }

    public function getCellen() {
        $query = "SELECT cel.*, (SELECT COUNT(*) FROM gedetineerde WHERE gedetineerde.huidige_cel = cel.cel_nummer) AS aantal FROM $this->table";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getAantalCellen() {
        $query = "SELECT huidige_cel, COUNT(*) AS aantal FROM gedetineerde
                  GROUP BY huidige_cel HAVING COALESCE(huidige_cel, 1, huidige_cel) <> 1";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getCel($cel_nummer) {
        $query = "SELECT * FROM gedetineerde WHERE huidige_cel = :cel";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':cel', $cel_nummer, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt;
    }

    public function getWijzigingen() {
        $query = "SELECT * FROM cel_gedetineerde INNER JOIN $this->table ON cel_gedetineerde.cel_id = cel.id
                  INNER JOIN gedetineerde ON gedetineerde.id = cel_gedetineerde.gedetineerde_id ORDER BY cel_gedetineerde.overplaatsing DESC LIMIT 10";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }
}
