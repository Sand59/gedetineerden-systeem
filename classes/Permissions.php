<?php
class Permissions {
   private $dbconn;

   public function __construct($dbconn) {
      $this->conn = $dbconn;
   }

   public function checkPermission($perm_code) {
      global $dbconn;

      // query
      $id = $_SESSION["id"];
      $rol_id = $_SESSION['rol_id'];

      // query kan simpeler
      $query = "SELECT perm_code FROM rol_permissions 
                INNER JOIN gebruiker ON rol_permissions.rol_id = gebruiker.rol_id 
                INNER JOIN permissions ON rol_permissions.perm_id = permissions.perm_id
                WHERE rol_permissions.rol_id = :rol_id AND perm_code = :perm_code AND id = :id";

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
      $stmt->bindParam(':perm_code', $perm_code, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
   
      $stmt->execute();

      if($stmt->rowCount() != 0) {
         return true;
      }
      else {
         return false;
      }
   }

   public function getRollen() {
      $query = "SELECT * FROM rol";

      $stmt = $this->conn->prepare($query);
     
      $stmt->execute();
      return $stmt;
   }  
   
   public function getPermissions() {
      $query = "SELECT * FROM permissions";

      $stmt = $this->conn->prepare($query);
     
      $stmt->execute();
      return $stmt;
   }

   public function addRol() {
      $query = "INSERT INTO rol (rol) VALUES ('Naam')";

      $stmt = $this->conn->prepare($query);
     
      $stmt->execute();
      return $stmt;
   }

   public function deleteRol($id) {
      $query = "DELETE FROM rol WHERE id = :id";

      $stmt = $this->conn->prepare($query);
     
      // bind variables
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $stmt->execute();

      // delete permissions
      $query = "DELETE FROM rol_permissions WHERE rol_id = :rolId";

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':rolId', $id, PDO::PARAM_INT);

      $stmt->execute();
      return $stmt;
   }

   public function updateNaamRol($rol, $id) {
      $query = "UPDATE rol
                SET rol = :rol
                WHERE id = :id"; 

      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $stmt->execute();
      return $stmt;
   }

   public function checkPermissions($rolId, $permId) {
      $query = "SELECT * FROM rol_permissions WHERE rol_id = :rolId AND perm_id = :permId";
                     
      $stmt = $this->conn->prepare($query);

      // bind variables
      $stmt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
      $stmt->bindParam(':permId', $permId, PDO::PARAM_INT);

      $stmt->execute();
      return $stmt;
   }

   public function setRollen($checked, $rolId, $permId) {
      if($checked == true) {
         $objPermissions = new Permissions($this->conn);
         
         // check for records
         $exist = $objPermissions->checkPermissions($rolId, $permId);

         if($exist->rowCount() == 0) {
            $query = "INSERT INTO rol_permissions (rol_id, perm_id) VALUES(:rolId, :permId)";
                     
            $stmt = $this->conn->prepare($query);
   
            // bind variables
            $stmt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
            $stmt->bindParam(':permId', $permId, PDO::PARAM_INT);
   
            $stmt->execute();
            return $stmt;
         }
      }

      else {
         $query = "DELETE FROM rol_permissions WHERE rol_id = :id AND perm_id = :perm_id";
         
         $stmt = $this->conn->prepare($query);

         // bind variables
         $stmt->bindParam(':id', $rolId, PDO::PARAM_INT);
         $stmt->bindParam(':perm_id', $permId, PDO::PARAM_INT);
         
         $stmt->execute();
         return $stmt;
      }
   }
}