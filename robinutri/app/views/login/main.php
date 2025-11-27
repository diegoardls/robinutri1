<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RobiNutri - Chat</title>
    <link rel="stylesheet" href="views/css/main_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div id="history-sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="menu-toggle-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h1>Historial de chat</h1>
        </div>
        <a href="#" class="new-chat">  Nuevo chat</a>

        <div class="sidebar-section recents">
            <h2>Recientes</h2>
            <span id="no-chats-text" style="font-size: 0.9em; opacity: 0.8; padding-left: 10px;">
                    No hay chats aún
            </span>

            <ul>

            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="#" class="footer-item" id="help-link">
                <i class="fas fa-question-circle"></i>
                <span class="item-text">Ayuda</span>
            </a>
            <a href="#" class="footer-item" id="config-link">
                <i class="fas fa-cog"></i>
                <span class="item-text">Configuración</span>
            </a>
        </div>
    </div>


    <div class="page-container">
        
        <a href="#" class="top-right-button icon-circle" id="open-profiles-sidebar">
            <img src="https://raw.githubusercontent.com/diegoardls/imagenes/1cbbf52e1f884be3df6d3f3035c685c25cee08b8/robinutri/Imagenes/Menu%20ni%C3%B1os.png" alt="Abrir Perfiles">
        </a>
        
        <div id="profile-sidebar" class="profile-sidebar-container">
            <div class="profile-sidebar-content">
                <div class="menu-header">
                    <div class="config-text">
                        <i class="fas fa-cog"></i> 
                        <div>
                            <strong>Configurar</strong>
                            <p>Perfiles</p>
                        </div>
                    </div>
                </div>
                <div class="profile-list">
                    <p class="profile-item">Perfil Name Padre/Madre</p>
                    <p class="profile-item">Perfil Name Hijo 1</p>
                    <p class="profile-item">Perfil Name Hijo 2</p>
                    <button class="add-profile-button">+ Agregar Perfil</button>
                </div>
            </div>
        </div>
        
        <div class="header-logo">
            <img src="https://raw.githubusercontent.com/diegoardls/imagenes/1cbbf52e1f884be3df6d3f3035c685c25cee08b8/robinutri/Imagenes/Image%20(1).png" alt="RobiNutri Logo" class="logo-img">
        </div>
        
        <div class="welcome-message" id="welcome-message">
            <h2>Hola, Bienvenido</h2>
            <h3>¿Qué se ofrece?</h3>
        </div>

        <div class="chat-main-container">
            <div class="chat-area" id="chat-area"></div>
                
        </div>
        
        <div class="side-palette">
            <div class="palette-icon">
                <img src="https://raw.githubusercontent.com/diegoardls/imagenes/1cbbf52e1f884be3df6d3f3035c685c25cee08b8/robinutri/Imagenes/manzana.png" alt="Icono Manzana"> </div>
            <div class="palette-arrow">
                <img src="https://raw.githubusercontent.com/diegoardls/imagenes/1cbbf52e1f884be3df6d3f3035c685c25cee08b8/robinutri/Imagenes/flechas.png" alt="Flechas de Retroceso"> </div>
        </div>
    </div>

    <div class="chat-input-container-fixed">
        <div class="chat-input-container">
            <div class="chat-robot-icon">
                <img src="https://raw.githubusercontent.com/diegoardls/imagenes/1cbbf52e1f884be3df6d3f3035c685c25cee08b8/robinutri/Imagenes/Image.png" alt="Robot Chat Icon"> </div>
            <input type="text" class="chat-input" id="chat-input" placeholder="Escribe aquí..."> 
            <button class="send-button" id="send-button">
                <i class="fas fa-angle-right"></i> </button>
        </div>
    </div>

    <script src="views/js/main_script.js"></script>
</body>
</html>