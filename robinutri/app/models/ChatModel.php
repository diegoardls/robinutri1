<?php
require_once 'Database.php';

class ChatModel {
    private $db;
    private $tableChats = 'chats';
    private $tableMensajes = 'mensajes';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Obtener todos los chats de un perfil
    public function getChatsByProfile($perfilId) {
        try {
            $query = "SELECT * FROM " . $this->tableChats . " 
                     WHERE perfil_id = :perfil_id 
                     ORDER BY fecha_ultimo_mensaje DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':perfil_id' => $perfilId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting chats: " . $e->getMessage());
            return [];
        }
    }

    // Crear nuevo chat
    public function createChat($perfilId, $nombreChat = null) {
        try {
            if (!$nombreChat) {
                $nombreChat = 'Chat de Nutrición';
            }
            
            $query = "INSERT INTO " . $this->tableChats . " 
                     (perfil_id, nombre_chat) 
                     VALUES (:perfil_id, :nombre_chat)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':perfil_id' => $perfilId,
                ':nombre_chat' => $nombreChat
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating chat: " . $e->getMessage());
            return false;
        }
    }

    // Obtener mensajes de un chat
    public function getMessages($chatId) {
        try {
            $query = "SELECT * FROM " . $this->tableMensajes . " 
                     WHERE chat_id = :chat_id 
                     ORDER BY fecha_creacion ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':chat_id' => $chatId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting messages: " . $e->getMessage());
            return [];
        }
    }

    // Guardar mensaje
    public function saveMessage($chatId, $mensaje, $tipo) {
        try {
            // 1. Guardar el mensaje
            $query = "INSERT INTO " . $this->tableMensajes . " 
                     (chat_id, mensaje, tipo) 
                     VALUES (:chat_id, :mensaje, :tipo)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':chat_id' => $chatId,
                ':mensaje' => $mensaje,
                ':tipo' => $tipo
            ]);

            // 2. Actualizar fecha del último mensaje del chat
            $updateQuery = "UPDATE " . $this->tableChats . " 
                           SET fecha_ultimo_mensaje = CURRENT_TIMESTAMP 
                           WHERE id = :chat_id";
            $stmt = $this->db->prepare($updateQuery);
            $stmt->execute([':chat_id' => $chatId]);

            return true;
        } catch (PDOException $e) {
            error_log("Error saving message: " . $e->getMessage());
            return false;
        }
    }

    // Obtener información de un chat
    public function getChatById($chatId) {
        try {
            $query = "SELECT c.*, p.nombre, p.apellido 
                     FROM " . $this->tableChats . " c
                     JOIN perfiles p ON c.perfil_id = p.id
                     WHERE c.id = :chat_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':chat_id' => $chatId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting chat: " . $e->getMessage());
            return null;
        }
    }

    // Eliminar chat
    public function deleteChat($chatId) {
        try {
            $query = "DELETE FROM " . $this->tableChats . " WHERE id = :chat_id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':chat_id' => $chatId]);
        } catch (PDOException $e) {
            error_log("Error deleting chat: " . $e->getMessage());
            return false;
        }
    }
}
?>