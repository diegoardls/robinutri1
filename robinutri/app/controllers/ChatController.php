<?php
require_once 'app/models/ChatModel.php';
require_once 'app/models/ProfileModel.php';

class ChatController {
    private $chatModel;
    private $profileModel;

    public function __construct() {
        $this->chatModel = new ChatModel();
        $this->profileModel = new ProfileModel();
        
        // ⭐⭐ CORRECCIÓN: Verificar si la sesión ya está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // ⭐⭐ TEMPORAL: asignar usuario por defecto (tu compañero lo quitará)
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['usuario_id'] = 1;
            $_SESSION['usuario_nombre'] = 'Padre';
        }
    }

    // Página principal del chat - mostrará perfiles o chat específico
    public function index() {
        echo "<!-- DEBUG: ChatController::index() llamado -->";
        echo "<!-- DEBUG: perfil_id: " . ($_GET['perfil_id'] ?? 'null') . " -->";
        
        $perfilId = $_GET['perfil_id'] ?? null;
        
        if ($perfilId) {
            echo "<!-- DEBUG: Mostrando chat específico -->";
            $this->mostrarChat($perfilId);
        } else {
            echo "<!-- DEBUG: Mostrando selector de perfiles -->";
            $this->mostrarSelectorPerfiles();
        }
    }

    private function mostrarChat($perfilId) {
        $perfil = $this->profileModel->getById($perfilId);
        
        if (!$perfil) {
            echo "Error: Perfil no encontrado";
            return;
        }

        $chats = $this->chatModel->getChatsByProfile($perfilId);
        
        // ⭐⭐ RUTA CORREGIDA
        require_once 'app/views/chat/index.php';
    }

    private function mostrarSelectorPerfiles() {
        $perfiles = $this->profileModel->getAll();
        
        // ⭐⭐ RUTA CORREGIDA
        require_once 'app/views/chat/select_profile.php';
    }

    // ... los otros métodos se mantienen igual
    public function createChat() {
        header('Content-Type: application/json');
        
        $perfilId = $_POST['perfil_id'] ?? null;
        
        if ($perfilId) {
            $chatId = $this->chatModel->createChat($perfilId);
            
            if ($chatId) {
                echo json_encode([
                    'success' => true,
                    'chat_id' => $chatId,
                    'message' => 'Chat creado exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear el chat'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se especificó el perfil'
            ]);
        }
    }

    public function sendMessage() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chatId = $_POST['chat_id'] ?? null;
            $mensaje = $_POST['mensaje'] ?? '';
            
            if ($chatId && !empty($mensaje)) {
                // Guardar mensaje del usuario
                $this->chatModel->saveMessage($chatId, $mensaje, 'user');
                
                // Respuesta temporal del bot
                $respuestaBot = "¡Hola! Soy RobiNutri. Estoy aquí para ayudarte con preguntas sobre nutrición infantil. ¿En qué puedo ayudarte?";
                $this->chatModel->saveMessage($chatId, $respuestaBot, 'bot');
                
                echo json_encode([
                    'success' => true,
                    'bot_response' => $respuestaBot
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos incompletos'
                ]);
            }
        }
    }

    public function loadMessages() {
        header('Content-Type: application/json');
        
        $chatId = $_GET['chat_id'] ?? null;
        
        if ($chatId) {
            $mensajes = $this->chatModel->getMessages($chatId);
            $chatInfo = $this->chatModel->getChatById($chatId);
            
            echo json_encode([
                'success' => true,
                'mensajes' => $mensajes,
                'chat_info' => $chatInfo
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se especificó el chat'
            ]);
        }
    }

    public function loadChats() {
        header('Content-Type: application/json');
        
        $perfilId = $_GET['perfil_id'] ?? null;
        
        if ($perfilId) {
            $chats = $this->chatModel->getChatsByProfile($perfilId);
            
            echo json_encode([
                'success' => true,
                'chats' => $chats
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se especificó el perfil'
            ]);
        }
    }
}
?>