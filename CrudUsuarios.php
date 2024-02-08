<?php

?><?php

require_once("Connection.php");

class Usuarios
{
    public function showUsuarios()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuarios";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        //return $result->fetch_array();
        //print_r($result->fetch_array());
        
        return $result->fetch_all(MYSQLI_BOTH);

    }

    
    public function addUsuario($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "INSERT INTO `usuarios` (`usuario`,`password`,`rol`) VALUES ('$data[0]', '$data[1]', '$data[2]');";
        $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);

    }

    public function editUsuario($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "UPDATE `usuarios` SET `usuario` = '$data[0]', `password` = '$data[1]', `rol` = '$data[2]' WHERE `usuarios`.`id_usuario` = '$data[3]';";

        //comprobar lo que sale por la query sql echo $sql;
        $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
    }

    public function UsuarioById($data){
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "SELECT * FROM usuarios WHERE id_usuario=$data[0]";
        $result = $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }

    public function deleteUsuario($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "DELETE FROM `usuarios` WHERE `usuarios`.`id_usuario` = $data ";
        $mySQL->query($sql);
    }
    public function UsuarioPermissions()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT `usuario` FROM `usuarios` WHERE `usuarios`.`rol` = 33";
        $result = $mySQL->query($sql);
        return $result->fetch_all(MYSQLI_BOTH);
    }

}


?>