<?php
class Bezoeker {
    private $dbconn;
    private $table = "bezoeker";

    public function __construct($dbconn) {
        $this->conn = $dbconn;
    }

    public function getDruppel($rfid_id) {
        $query = "SELECT * FROM rfid_druppel WHERE rfid_id = :rfid_id";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':rfid_id', $rfid_id, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function bezoekerGeschiedenis($id) {
        //977428824959
        $query = "SELECT * FROM rfid_geschiedenis WHERE rfid_id = :id AND vertrek IS NULL AND ingecheckt = 'Ja'";
        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $query = "UPDATE rfid_geschiedenis SET vertrek = CURRENT_TIMESTAMP, ingecheckt = 'Nee' WHERE rfid_id = :id";

            $stmt = $this->conn->prepare($query);

            // bind variables
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return 'uit';
        }

        else {
            $query = "INSERT INTO rfid_geschiedenis (rfid_id, aankomst, ingecheckt, naam)
                      VALUES (:id, CURRENT_TIMESTAMP, 'Ja', (SELECT naam FROM rfid_druppel WHERE rfid_id = :id))";

            $stmt = $this->conn->prepare($query);

            // bind variables
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return 'in';
        }
    }

    public function addBezoekerMedewerker($rfid, $naam, $email) {
        $query = "INSERT INTO rfid_druppel (rfid_id, naam, email) VALUES (:rfid, :naam, :email)";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':rfid', $rfid, PDO::PARAM_STR);
        $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt;
    }

    public function getBezoeker($id) {
        $query = "SELECT *, DATE_FORMAT(datum, '%d %M  %Y') AS datum
                  FROM $this->table WHERE gedetineerde_id = :id";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function getBezoekers() {
        $query = "SELECT * FROM rfid_geschiedenis
                  INNER JOIN rfid_druppel ON rfid_druppel.rfid_id = rfid_geschiedenis.rfid_id
                  ORDER BY rfid_geschiedenis.aankomst DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addBezoeker($naam, $datum, $id, $tijd_van, $tijd_tot, $email) {
        $query = "INSERT INTO $this->table
                  SET naam = :naam, datum = :datum, gedetineerde_id = :id, tijd_van = :tijd_van, tijd_tot = :tijd_tot, email = :email";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
        $stmt->bindParam(':datum', $datum, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':tijd_van', $tijd_van, PDO::PARAM_STR);
        $stmt->bindParam(':tijd_tot', $tijd_tot, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        }

        catch (PDOException $e) {
            return false;
        }
    }
}
