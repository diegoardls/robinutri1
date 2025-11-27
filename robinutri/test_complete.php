<?php
require_once 'config/database.php';
require_once 'app/models/Database.php';
require_once 'app/models/ProfileModel.php';

// Probar el modelo directamente
$model = new ProfileModel();

$testData = [
    'nombre' => 'Test',
    'apellido' => 'User', 
    'edad' => '10',
    'alergias' => 'Ninguna',
    'enfermedades' => 'Ninguna',
    'observaciones' => 'Test completo'
];

$result = $model->create($testData);

if ($result) {
    echo "✅ Modelo creó perfil exitosamente. ID: " . $model->getLastInsertId();
} else {
    echo "❌ Modelo NO pudo crear perfil";
    
    // Ver errores de PHP
    echo "<pre>";
    print_r(error_get_last());
    echo "</pre>";
}
?>