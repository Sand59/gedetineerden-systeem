<?php
class Gebruiker {
    private $dbconn;
    private $table = "gebruiker";

    public function __construct($dbconn) {
        $this->conn = $dbconn;
    }

    public function getGebruikers() {
        $query = "SELECT gebruiker.*, rol FROM gebruiker INNER JOIN rol ON rol.id = rol_id ORDER BY gebruiker.id ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getGebruiker($id) {
      $query = "SELECT gebruiker.*, rol FROM gebruiker INNER JOIN rol ON rol.id = rol_id WHERE gebruiker.id = :id";

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $stmt->execute();
      return $stmt;
  }

    public function getGebruikerLogin($inlognaam) {
        $query = "SELECT gebruiker.*, rol FROM $this->table
                  INNER JOIN rol ON gebruiker.rol_id = rol.id
                  WHERE inlognaam = :inlognaam";

        $stmt = $this->conn->prepare($query);

        // bind variables
        $stmt->bindParam(':inlognaam', $inlognaam, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt;
    }

    public function updateGebruiker($naam, $inlognaam, $email, $rol, $id) {
      $query = "UPDATE gebruiker SET naam = :naam, inlognaam = :inlognaam, email = :email, rol_id = :rol_id WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
      $stmt->bindParam(':inlognaam', $inlognaam, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':rol_id', $rol, PDO::PARAM_INT);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      
      $stmt->execute();
      return true;
   }

    public function addGebruiker($naam, $inlognaam, $wachtwoord_hash, $email, $rol) {
      $query = "INSERT INTO gebruiker (naam, inlognaam, wachtwoord, email, rol_id) VALUES (:naam, :inlognaam, :wachtwoord, :email, :rol_id)";

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
      $stmt->bindParam(':inlognaam', $inlognaam, PDO::PARAM_STR);
      $stmt->bindParam(':wachtwoord', $wachtwoord_hash, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':rol_id', $rol, PDO::PARAM_INT);

      $stmt->execute();
      return true;
   }
}
