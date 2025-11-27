<?php
session_start();

// Cargar configuración
require_once 'config/database.php';
require_once 'app/models/Database.php';

$request = $_SERVER['REQUEST_URI'];
$base_path = '/robinutri';

if (strpos($request, '/index.php/') !== false) {
    $path = str_replace($base_path . '/index.php', '', $request);
} else {
    $path = str_replace($base_path, '', $request);
}

$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Enrutamiento
$routes = [
    '' => 'HomeController@index',           // → Redirige a chat
    'home' => 'HomeController@index',       // → Redirige a chat  
    'chat' => 'ChatController@index',       // → Selector de perfiles o chat
    'chat/create' => 'ChatController@createChat',
    'chat/send' => 'ChatController@sendMessage',
    'chat/messages' => 'ChatController@loadMessages',
    'chat/chats' => 'ChatController@loadChats',
    'profiles' => 'ProfileController@index', // → Gestión de perfiles
    'profiles/save' => 'ProfileController@save',
    'profiles/load' => 'ProfileController@load',
    'profiles/loadAll' => 'ProfileController@loadAll',
    'profiles/delete' => 'ProfileController@delete',
    
    // ⭐⭐ RUTAS PARA TU COMPAÑERO (LOGIN) ⭐⭐
    'login' => 'LoginController@index',      // ← Tu compañero implementará
    'login/auth' => 'LoginController@authenticate', // ← Tu compañero implementará
    'logout' => 'LoginController@logout',    // ← Tu compañero implementará
];

$controllerName = 'ProfileController';
$method = 'index';

foreach ($routes as $route => $action) {
    if ($path === $route) {
        list($controllerName, $method) = explode('@', $action);
        break;
    }
}

$controllerFile = "app/controllers/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(404);
            echo "Error: Método '$method' no encontrado";
        }
    } else {
        http_response_code(500);
        echo "Error: Clase '$controllerName' no encontrada";
    }
} else {
    http_response_code(404);
    echo "Error: Archivo no encontrado: $controllerFile";
}
?>