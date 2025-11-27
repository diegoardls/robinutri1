<?php
class HomeController {
    public function index() {
        // ⭐⭐ TEMPORAL: Redirigir directamente al chat
        // Tu compañero cambiará esto por la lógica de login
        header('Location: /robinutri/index.php/chat');
        exit();
    }
}
?>