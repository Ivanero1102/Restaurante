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
    $controlCuenta->controlSesiones();
    ?>
    <div>
    <h1>Bienvenido <?=$_SESSION['usuario']?></h1>
    <form action="index.php" method="post">
        <span><input type='submit' name='cerrarSesion' value='Cerrar sesion' style='font-size: 20px; font-weight:25px'></span>
    </form>
    </div>
    <table>
        <tr>
            <th>Platos</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Cantidad</th>
        </tr>
    <?php
    $controlGeneral->mostrarPlatos();
    ?>
    </table>
    <div>
    <form action="cuenta.php" method="post">
        <span><input type='submit' name='cuenta' value='Pagar' style='font-size: 20px; font-weight:25px; margin-top: 15px;'></span>
    </form>
    </div>
</body>
</html>