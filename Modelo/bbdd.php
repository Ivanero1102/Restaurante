<?php
class BBDD{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $DB = "restaurante";

    //Codifica las contraseñas
    function codificar($contraseña){
        return $cifrado = password_hash($contraseña, PASSWORD_DEFAULT);
    }

    //Conexion al servidor
    function conexionServidor(){
        try {
            $conn = new PDO("mysql:host=".$this->servername.";",$this->username,  $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }
    }

    //Funcion que crea la BBDD en caso de k no exista aun
    function crearBBDD(){
        $conn = $this->conexionServidor();
        try {
            $sql= "CREATE database IF NOT exists $this->DB";
            $conn->query($sql);
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }
    }

    //Conexion a la BBDD
    function conexionBBDD(){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->DB", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }
    }
    
    //Creacion de las tablas en la BBDD e introduccion de los datos
    function crearTablas(){
        $conn = $this->conexionBBDD();
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
                categoria  enum('vegano','sin gluten', 'sin lactosa', 'normal'))";
            $conn->query($sql);
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }

        try {
            $cifrado1 = $this->codificar("Daw1");
            $cifrado2 = $this->codificar("Daw2");
            $cifrado3 = $this->codificar("Daw3");
            $sql="INSERT INTO usuario (usuario_id, usuario, contraseña) VALUES (1, 'Pepe', '".$cifrado1."') ON DUPLICATE KEY UPDATE usuario_id = 1, usuario = 'Pepe', contraseña =  '".$cifrado1."';
                    INSERT INTO usuario (usuario_id, usuario, contraseña) VALUES (2, 'Jose', '".$cifrado2."') ON DUPLICATE KEY UPDATE usuario_id = 2, usuario = 'Jose', contraseña =  '".$cifrado2."';
                    INSERT INTO usuario (usuario_id, usuario, contraseña) VALUES (3, 'Carmela', '".$cifrado3."') ON DUPLICATE KEY UPDATE usuario_id = 3, usuario = 'Carmela', contraseña =  '".$cifrado3."'";
            $conn->query($sql);
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }

        try {
            $sql="INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (1, 'paella', '33', 'normal') ON DUPLICATE KEY UPDATE plato_id = 1, nombre = 'paella', precio =  '33', categoria = 'normal';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (2, 'hamburguesa', '12', 'sin gluten') ON DUPLICATE KEY UPDATE plato_id = 2, nombre = 'hamburguesa', precio =  '12', categoria = 'sin gluten';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (3, 'brochetas', '18', 'vegano') ON DUPLICATE KEY UPDATE plato_id = 3, nombre = 'paella', precio =  '18', categoria = 'vegano';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (4, 'solomillo', '25', 'normal') ON DUPLICATE KEY UPDATE plato_id = 4, nombre = 'solomillo', precio =  '25', categoria = 'normal';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (5, 'macarrones bolognesa', '12', 'normal') ON DUPLICATE KEY UPDATE plato_id = 5, nombre = 'macarrones bolognesa', precio =  '12', categoria = 'normal';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (6, 'ensalada', '15', 'normal') ON DUPLICATE KEY UPDATE plato_id = 6, nombre = 'ensalada', precio =  '15', categoria = 'vegano';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (7, 'quiche', '16', 'normal') ON DUPLICATE KEY UPDATE plato_id = 7, nombre = 'quiche', precio =  '16', categoria = 'sin gluten';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (8, 'crepes', '7', 'normal') ON DUPLICATE KEY UPDATE plato_id = 8, nombre = 'crepes', precio =  '7', categoria = 'sin gluten';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (9, 'mousse', '5', 'normal') ON DUPLICATE KEY UPDATE plato_id = 9, nombre = 'mousse', precio =  '5', categoria = 'vegano';
                    INSERT INTO plato (plato_id, nombre, precio, categoria) VALUES (10, 'tarta de queso', '8', 'normal') ON DUPLICATE KEY UPDATE plato_id = 10, nombre = 'tarta de queso', precio =  '8', categoria = 'normal'";
            $conn->query($sql);
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }
    }

    //Login de usuario
    function login($id, $usuario, $clave){
        try {
            $conn = $this->conexionBBDD();
            $sql ="SELECT contraseña FROM usuario where usuario_id = ? AND usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$id);
            $stmt->bindParam(2,$usuario);
            $stmt->execute();
            $contra = $stmt->fetch(PDO::FETCH_ASSOC);
            if($contra['contraseña'] != null){
                if(password_verify($clave, $contra['contraseña'])){
                    $_SESSION['usuario']=$usuario;
                    header("Location:../Vista/index.php");
                }else{
                    $msg = "Contraseña mal introducida";
                    header("Location:../Vista/index.php?msg=$msg");
                }
            }else{
                $msg = "Id de usuario o usuario mal introducido";
                header("Location:../Vista/index.php?msg=$msg");
            }
        }catch(PDOException $e){
            die("Error:". $e->getMessage());
        }
    }

    function sacarPlatos(){
        $conn = $this->conexionBBDD();
        $sql= "SELECT * FROM plato";
        return $conn->query($sql);
    }
}
?>