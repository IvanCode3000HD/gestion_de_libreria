<?php

class Connection{
    private $server = 'localhost';
    private $user = 'root';
    private $password;
    private $db = 'isg_libreria';


    public function getConnection(){
        return $conexion = new mysqli(
            $this->server,
            $this->user,
            $this->password,
            $this->db
        );
    }  

    public function closeConnection($conexion){

        $conexion->close();
    }


}


$con = new Connection();

if ($con->getConnection()->connect_error) {
    print_r($con->getConnection()->connect_error);
}else{
    //echo "Database connected<br>";
}
/*
$mySQL = $con->getConnection();
if ($mySQL->connect_error){
    echo "Database error conexion";

}else{
    echo "Database connected<br>";
}*/

    ?>