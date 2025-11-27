<?php
class CuentaModel{
    private $conn;
    private $table = "cuenta";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function existeCorreo($correo){
        $query = "SELECT id_cuenta FROM " . $this->table . " WHERE email = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    public function crear($nombre,$apellido,$correo,$contraseña){
        if ($this->existeCorreo($correo)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table . "
         (nombre_cuenta, apellido, email, contrasena) 
         VALUES (:nombre, :apellido, :correo, :contrasena)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido", $apellido);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":contrasena", $contraseña);
        return $stmt->execute();
    }
    public function obtenerPasswordPorEmail($email){
        $query = "SELECT contrasena FROM cuenta Where email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        try{
            $stmt->execute(); 
            return $stmt->fetch(); 
        }catch (ExceptionType $e) {
            echo "error de conexion";
        }
    }
}
?>