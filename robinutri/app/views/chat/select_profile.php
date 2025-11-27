<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RobiNutri - Seleccionar Perfil</title>
    <link rel="stylesheet" href="/robinutri/public/css/configuracion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="page-container" style="padding-top: 50px;">
        
        <!-- Header -->
        <div class="registro-header">
            <img src="/robinutri/public/imagenes/Logo.png" alt="RobiNutri Logo" class="logo-img-config">
            <h1>Bienvenido a RobiNutri</h1>
            <p class="slogan">Selecciona un perfil para comenzar a chatear</p>
        </div>

        <!-- Lista de Perfiles -->
        <div class="registro-perfil-area">
            <div class="perfiles-creados-lista" style="width: 100%;">
                <h3>Perfiles Disponibles</h3>
                
                <?php if (!empty($perfiles)): ?>
                    <?php foreach ($perfiles as $perfil): ?>
                        <div class="profile-display-item profile-chat-item" 
                             onclick="window.location.href='/robinutri/index.php/chat?perfil_id=<?= $perfil['id'] ?>'">
                            <div class="profile-info">
                                <span class="profile-name">
                                    <strong><?= htmlspecialchars($perfil['nombre']) ?> <?= htmlspecialchars($perfil['apellido']) ?></strong>
                                </span>
                                <span class="profile-details">
                                    Edad: <?= htmlspecialchars($perfil['edad']) ?> años
                                    <?php if (!empty($perfil['alergias'])): ?>
                                        | Alergias: <?= htmlspecialchars($perfil['alergias']) ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="profile-actions">
                                <i class="fas fa-comments chat-icon"></i>
                                <span>Chatear</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px;">
                        <p style="margin-bottom: 20px;">No hay perfiles creados todavía.</p>
                        <a href="/robinutri/index.php/profiles" class="green-btn" style="display: inline-block; padding: 12px 30px;">
                            Crear Primer Perfil
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botón para gestionar perfiles -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="/robinutri/index.php/profiles" class="continue-btn green-btn">
                <i class="fas fa-cog"></i> Gestionar Perfiles
            </a>
        </div>

    </div>

    <style>
        .profile-chat-item {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .profile-chat-item:hover {
            border-color: #42b8b5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .chat-icon {
            color: #42b8b5;
            margin-right: 8px;
        }
        
        .slogan {
            color: #A390D3;
            font-size: 1.1em;
            margin-top: 10px;
        }
    </style>
</body>
</html>