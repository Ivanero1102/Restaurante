<?php
class controlCuenta{
    function borrarCuenta(){
        session_unset();
        session_destroy();
    }
    function controlSesiones(){
        if(!isset($_SESSION['usuario'])){
            header("Location:../Vista/index.php");
        }
    }
}
?>