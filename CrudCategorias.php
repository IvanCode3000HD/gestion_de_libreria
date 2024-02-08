<?php

?><?php

require_once("Connection.php");

class Categorias
{
    public function showCategorias()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM categorias";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        //return $result->fetch_array();
        //print_r($result->fetch_array());
        
        return $result->fetch_all(MYSQLI_BOTH);

    }

    
    public function addCategoria($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "INSERT INTO `categorias` (`categoria`) VALUES ('$data[0]');";
        $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);

    }

    public function editCategoria($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "UPDATE `categorias` SET `categoria` = '$data[0]' WHERE `categorias`.`id_categoria` = '$data[1]';";

        //comprobar lo que sale por la query sql echo $sql;
        $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
    }

    public function CategoriaById($data){
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "SELECT * FROM categorias WHERE id_categoria=$data[0]";
        $result = $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }

    public function deleteCategoria($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "DELETE FROM `categorias` WHERE `categorias`.`id_categoria` = $data";
        $mySQL->query($sql);
    }
}

//$usuarios = new Usuarios();
//$usuarios -> showUsuarios();

?>