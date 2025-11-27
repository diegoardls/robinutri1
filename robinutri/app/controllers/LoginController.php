<?php
require_once 'config/database.php';
require_once 'models/CuentaModel.php';
class Controller{
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->model = new CuentaModel($db);
    }
    public function index(){
        require_once 'views/inicio.php';
    }
    public function verRegistro() {
    require_once 'views/registro.php';
    }
    public function verMain(){
        require_once 'views/main.php';
    }
    public function accionCuenta(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['accion']) && $_POST['accion'] === 'login') {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $contraseña = $this->model->obtenerPasswordPorEmail($email)[0];
                if($password === $contraseña){
                    $this->verMain();
                }else{
                    echo'<script type="text/javascript">
                            alert("Credenciales de acceso inválidas");
                            window.location.href="index.php"
                        </script>';
                }
            }
            if(isset($_POST['accion']) && $_POST['accion'] === 'register'){
                $nombre = htmlspecialchars($_POST['nombre']);
                $apellido = htmlspecialchars($_POST['apellido']);
                $correo = htmlspecialchars($_POST['email']);
                $contraseña = htmlspecialchars($_POST['password']);
                $succes = $this->model->crear($nombre,$apellido,$correo,$contraseña);
                if($succes){
                    $this->verMain();
                }else{
                    $this->verRegistro();
                    echo'<script type="text/javascript">
                            alert("Correo en uso");
                        </script>';
                }
            }
        }
    }
}
?>