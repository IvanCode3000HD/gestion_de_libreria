<?php

?><?php

require_once("Connection.php");

class Libros
{
    public function showLibros()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT libros.*,categorias.categoria FROM `libros` JOIN `categorias` ON libros.id_categoria=categorias.id_categoria";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        //return $result->fetch_array();
        //print_r($result->fetch_array());
        
        return $result->fetch_all(MYSQLI_BOTH);

    }

    public function addLibro($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "INSERT INTO `libros` (`titulo`,`portada`,`autor`,`id_categoria`,`precio`) VALUES ('$data[0]','$data[1]','$data[2]', '$data[3]', '$data[4]');";
        $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);

    }

    public function editLibro($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "UPDATE `libros` SET `titulo` = '$data[0]', `portada` = '$data[1]', `autor` = '$data[2]', `id_categoria` = '$data[3]' , `precio` = '$data[4]' WHERE `libros`.`id_libro` = '$data[5]';";

        echo $sql;
        $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
    }

    public function LibroById($data){
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();

        $sql = "SELECT * FROM libros WHERE id_libro=$data[0]";
        $result = $mySQL->query($sql);
        
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }
    public function deleteLibro($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "DELETE FROM `libros` WHERE `libros`.`id_libro` = $data ";
        $mySQL->query($sql);
    }

  public function filtrarLibroAlfabeticamente()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM `libros` ORDER BY `libros`.`titulo` ASC";
        $mySQL->query($sql);
        $result = $mySQL->query($sql);
        return $result->fetch_all(MYSQLI_BOTH);

    }
    public function filtrarAutorInput($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM `libros` WHERE `autor` = '$data'";
        //echo $sql;

        $mySQL->query($sql);
        $result = $mySQL->query($sql);
        return $result->fetch_all(MYSQLI_BOTH);

    }

}

//$usuarios = new Usuarios();
//$usuarios -> showUsuarios();

?>