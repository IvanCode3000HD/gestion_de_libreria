<?php
require("CrudUsuarios.php");
require("CrudCategorias.php");
require("CrudLibros.php");



if (isset($_GET["id_usuario_del"])) {
    //borrar
    $id = $_GET["id_usuario_del"];
    echo $id;
    $data = array($id);

    $dataBase = new Usuarios();
    $dataBase->deleteUsuario($id);

    header("location:Usuarios.php");
}

if (isset($_GET["id_categoria_del"])) {
    //borrar
    $id = $_GET["id_categoria_del"];
    echo $id;
    $data = array($id);

    $dataBase = new Categorias();
    $dataBase->deleteCategoria($id);

    header("location:Categorias.php");
}

if (isset($_GET["id_libro_del"])) {
    //borrar
    $id = $_GET["id_libro_del"];
    echo $id;
    $data = array($id);

    $dataBase = new Libros();
    $dataBase->deleteLibro($id);

    header("location:Libros.php");
}

?>