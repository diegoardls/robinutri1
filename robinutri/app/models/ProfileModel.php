<?php
require_once 'Database.php';

class ProfileModel {
    private $db;
    private $table = 'perfiles';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY fecha_creacion DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting profiles: " . $e->getMessage());
            return [];
        }
    }

    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                     (nombre, apellido, edad, alergias, enfermedades, observaciones) 
                     VALUES (:nombre, :apellido, :edad, :alergias, :enfermedades, :observaciones)";
            
            $stmt = $this->db->prepare($query);
            
            $result = $stmt->execute([
                ':nombre' => $data['nombre'],
                ':apellido' => $data['apellido'],
                ':edad' => $data['edad'],
                ':alergias' => $data['alergias'] ?? '',
                ':enfermedades' => $data['enfermedades'] ?? '',
                ':observaciones' => $data['observaciones'] ?? ''
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Error creating profile: " . $e->getMessage());
            return false;
        }
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting profile: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting profile by ID: " . $e->getMessage());
            return null;
        }

    }
    public function update($id, $data) {
        try {
            $query = "UPDATE " . $this->table . " 
                    SET nombre = :nombre, apellido = :apellido, edad = :edad, 
                        alergias = :alergias, enfermedades = :enfermedades, 
                        observaciones = :observaciones 
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            
            $result = $stmt->execute([
                ':nombre' => $data['nombre'],
                ':apellido' => $data['apellido'],
                ':edad' => $data['edad'],
                ':alergias' => $data['alergias'] ?? '',
                ':enfermedades' => $data['enfermedades'] ?? '',
                ':observaciones' => $data['observaciones'] ?? '',
                ':id' => $id
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Error updating profile: " . $e->getMessage());
            return false;
        }
    }
}
?>