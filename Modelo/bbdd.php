<?php


//password_hash(contraseña, algoritmo que vamos a usar, salt ya no se usa , cost o vueltas que da el algoritmo)
// $contraseña = "Hola";
// $cifrado = password_hash($contraseña, PASSWORD_DEFAULT);
// echo $cifrado;
// echo "<br>";
// echo $contraseña;
// echo "<br>";
// $prueba = [password_hash("Hola", PASSWORD_DEFAULT), password_hash("HOLA", PASSWORD_DEFAULT)];
// foreach ($prueba as $key => $value) {
//     if(password_verify($contraseña, $value)){
//         echo "Verificado";
//         echo "<br>";
//     }else{
//         echo "Error";
//         echo "<br>";
//     }
// }

$servername = "localhost";
$username = "root";
$password = "";
$DB = "restaurante";

//Conexion servidor
try {
    $conn = new PDO("mysql:host=".$servername.";",$username,  $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

//Creacion de la BBDD en caso de k no exista
try {
    $sql= "CREATE database IF NOT exists $DB";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

// Conexion BBDD
try {
    $conn = new PDO("mysql:host=$servername;dbname=$DB", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

//Creacion de la tabla
try {
    $sql="CREATE TABLE IF NOT EXISTS usuario (
        usuario_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        usuario varchar(20) DEFAULT NULL,
        contraseña varchar(80) DEFAULT NULL)";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="CREATE TABLE IF NOT EXISTS plato (
        plato_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre varchar(20) DEFAULT NULL,
        precio int(5) DEFAULT NULL,
        categoria varchar(20) DEFAULT NULL UNIQUE)";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="CREATE TABLE IF NOT EXISTS categoria (
        categoria_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre varchar(20) DEFAULT NULL)";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="INSERT INTO categoria (categoria_id, nombre) VALUES (NULL, 'vegano') WHERE NOT EXISTS (SELECT * FROM categoria WHERE nombre = 'vegano')";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="INSERT INTO categoria (categoria_id, nombre) VALUES (NULL, 'sin gluten') WHERE NOT EXISTS (SELECT * FROM categoria WHERE nombre = 'sin gluten')";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="INSERT INTO categoria (categoria_id, nombre) VALUES (NULL, 'sin lactosa') WHERE NOT EXISTS (SELECT * FROM categoria WHERE categoria = 'sin lactosa')";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

try {
    $sql="INSERT INTO categoria (categoria_id, nombre) VALUES (NULL, 'normal') WHERE NOT EXISTS (SELECT * FROM categoria WHERE nombre = 'normal')";
    $conn->query($sql);
}catch(PDOException $e){
    die("Error:". $e->getMessage());
}

// CREATE TABLE `restaurante`.`plato` (`plato_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT , `nombre` INT(20) NOT NULL , 
// `precio` INT(5) NOT NULL , `categoria` VARCHAR(20) NOT NULL , PRIMARY KEY (`plato_id`), UNIQUE (`categoria`)) ENGINE = InnoDB;

//Crear nuevo usuario
// if (isset($_POST['crear'])) {
//     echo "Funciona crear";
//     try {
//         $cifrado = password_hash($_POST['password'], PASSWORD_DEFAULT);
//         $sql ="INSERT INTO usuario (usuario_id, usuario, contraseña) VALUES (NULL, ?, ?)";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(1,$_POST['usuario']);
//         $stmt->bindParam(2,$cifrado);
//         $stmt->execute();
//         $msg = "Usuario creado correctamente";
//         header("location:index.php?msg=$msg");
//     }catch(PDOException $e){
//         $msg = "Error al crear el usuario";
//         header("location:nuevo.php?msg=$msg");
//     }
// }

// //Login
// if (isset($_POST['login'])) {
//     try {
//         $sql ="SELECT contraseña FROM usuario where usuario_id = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(1,$_POST['id']);
//         $stmt->execute();
//         $contra = $stmt->fetch(PDO::FETCH_ASSOC);
//         if($contra['contraseña'] != null){
//             if(password_verify($_POST['password'], $contra['contraseña'])){
//                 header("Location:pagina.html");
//             }else{
//                 $msg = "Contraseña mal introducida";
//                 header("location:index.php?msg=$msg");
//             }
//         }else{
//             $msg = "Id de usuario no encontrada";
//             header("location:index.php?msg=$msg");
//         }
//     }catch(PDOException $e){
//         die("Error:". $e->getMessage());
//     }
// }
?>