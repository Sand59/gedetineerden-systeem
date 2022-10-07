<?php
class Gedetineerde {
    private $dbconn;
    private $table = "gedetineerde";

    public function __construct($dbconn) {
        $this->conn = $dbconn;
    }

    public function getGedetineerden() {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getGedetineerdeCel($id) {
        $query = "SELECT cel_nummer, DATE_FORMAT(overplaatsing, '%d %M  %Y, %h:%i') AS overplaatsing FROM cel_gedetineerde
                  INNER JOIN cel ON cel_gedetineerde.cel_id = cel.id
                  WHERE gedetineerde_id = :id ORDER BY overplaatsing DESC";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    public function getGedetineerde($id) {
        $query =  "SELECT * FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt;
    }

    public function updateGedetineerde($naam, $geboortedatum, $geslacht, $huidige_cel, $bsn_nummer, $gedrag, $datum_arrestatie, $datum_aankomst, $datum_vrijlating, $id) {
        // update gedetineerde tabel
        $query = "UPDATE $this->table
                  SET naam = :naam, geboortedatum = :geboortedatum, geslacht = :geslacht, huidige_cel = :huidige_cel, bsn_nummer = :bsn_nummer, gedrag = :gedrag, datum_arrestatie = :datum_arrestatie, datum_aankomst = :datum_aankomst, datum_vrijlating = :datum_vrijlating
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
        $stmt->bindParam(':geboortedatum', $geboortedatum, PDO::PARAM_STR);
        $stmt->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
        $stmt->bindParam(':huidige_cel', $huidige_cel, PDO::PARAM_STR);
        $stmt->bindParam(':bsn_nummer', $bsn_nummer, PDO::PARAM_INT);
        $stmt->bindParam(':gedrag', $gedrag, PDO::PARAM_STR);
        $stmt->bindParam(':datum_arrestatie', $datum_arrestatie, PDO::PARAM_STR);
        $stmt->bindParam(':datum_aankomst', $datum_aankomst, PDO::PARAM_STR);
        $stmt->bindParam(':datum_vrijlating', $datum_vrijlating, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        }

        catch (PDOException $e) {
            return false;
        }


        // celgeschiedenis bijhouden
        $query = "INSERT INTO cel_gedetineerde (gedetineerde_id, cel_id)
                  VALUES (:gedetineerde_id, (SELECT id FROM cel WHERE cel_nummer = :cel_id LIMIT 1))";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':gedetineerde_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':cel_id', $huidige_cel, PDO::PARAM_STR);

        $stmt->execute();


        // zet laatste wijziging in tabel cel
        $query = "UPDATE cel SET laatste_wijziging = CURRENT_TIMESTAMP
                  WHERE cel_nummer = :huidige_cel";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':huidige_cel', $huidige_cel, PDO::PARAM_STR);

        $stmt->execute();
        return true;
    }

    public function deleteGedetineerde(int $id) {
        $query = "DELETE FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addGedetineerde($naam, $geboortedatum, $geslacht, $adres, $bsn_nummer, $gedrag, $datum_arrestatie, $datum_aankomst, $datum_vrijlating, $cel) {
        $query = "INSERT INTO $this->table
                  SET naam = :naam, geboortedatum = :geboortedatum, geslacht = :geslacht, adres = :adres, bsn_nummer = :bsn_nummer, gedrag = :gedrag, datum_arrestatie = :datum_arrestatie, datum_aankomst = :datum_aankomst, datum_vrijlating = :datum_vrijlating, huidige_cel = :cel";

        $stmt = $this->conn->prepare($query);

        // bind variable values
        $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
        $stmt->bindParam(':geboortedatum', $geboortedatum, PDO::PARAM_STR);
        $stmt->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
        $stmt->bindParam(':adres', $adres, PDO::PARAM_STR);
        $stmt->bindParam(':bsn_nummer', $bsn_nummer, PDO::PARAM_STR);
        $stmt->bindParam(':gedrag', $gedrag, PDO::PARAM_STR);
        $stmt->bindParam(':datum_arrestatie', $datum_arrestatie, PDO::PARAM_STR);
        $stmt->bindParam(':datum_aankomst', $datum_aankomst, PDO::PARAM_STR);
        $stmt->bindParam(':datum_vrijlating', $datum_vrijlating, PDO::PARAM_STR);
        $stmt->bindParam(':cel', $cel, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        }

        catch (PDOException $e) {
            return false;
        }
    }
}
