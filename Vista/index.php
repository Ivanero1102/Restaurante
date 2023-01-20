<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilos.css"/>
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    include('../Controlador/controlGeneral.php');
    include('../Controlador/controlCuenta.php');
    $controlCuenta = new controlCuenta();
    $controlGeneral = new controlGeneral();
    if(isset($_POST['cerrarSesion'])){
        $controlCuenta->borrarCuenta();
    }
    if(isset($_SESSION['usuario'])){
        header("Location:../Vista/platos.php");
    }
    ?>
    <form action="" method="post">
        <label for="id">Id:</label>
        <input type="number" name="id" max="99999" min="1" required></input>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required></input>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" maxlength="20" required></input>
        <p><input type="submit" name="login" value="Ingersar"></p>
    </form>
    <?php
    $controlGeneral->comprobarLogin();
    if(isset($_GET['msg'])){
        echo "<br>".$_GET['msg'];
    }
    ?>
</body>
</html>