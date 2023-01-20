<?php
include("../Modelo/bbdd.php");
class controlGeneral{
    private $bbdd;
    function __construct(){
        $this->bbdd = new BBDD; 
    }

    function comprobarLogin(){
        if (isset($_POST['login'])) {
            $this->bbdd->login($_POST['id'], $_POST['usuario'],$_POST['password']);
        }
    }

    function mostrarPlatos(){
        foreach ($this->bbdd->sacarPlatos() as $row){
        echo "<tr><td>".$row["nombre"]."</td>
            <td>".$row["precio"]."</td>
            <td>".$row["categoria"]."</td>
            <td> 0 </td>
            <td><form action='' method='post'><span><input type='submit' name='añadir' value='+' style='font-size: 20px; font-weight:25px'></span></form></td>
            <td><form action='' method='post'><span><input type='submit' name='quitar' value='-' style='font-size: 20px; font-weight:25px'></span></form></td>
            </tr>";
        }
    }
}
?>