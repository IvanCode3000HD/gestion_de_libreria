<?php
include("menuPublic.php");
include("CrudCategorias.php");
include("CrudLibros.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.css" type="text/css">
    <title>Parte publica</title>
</head>

<script>

</script>

<style>
    .p-categoria {
        padding-left: 15px;
    }

    .img-libro {

        height: 200px;
        width: 150px;
        margin: 10px;
        float: left;
        border-radius: 15px;
    }

    .container {
        margin-left: 5px;
    }

    .menu-filters {
        position: absolute;
        top: 100px;
        /* Ajusta según sea necesario */
        right: 10px;
        /* Ajusta según sea necesario */
        margin-left: 15px;
    }
</style>

<body>

    <?php

    if (isset($_GET["verCategorias"])) {
        //realizar funcion pintar de las categorias o cargar algun listado
//hay que pasarle de algun modo (usando el crud correspondiente) el listado de todas las categorias para luego poder darle formato
    
        //codigo para traer el listado de categorias
    
        $dataBase = new Categorias();
        $categorias = $dataBase->showCategorias();
        ?>
        <h1>Nuestras categorias!!</h1>
        <?php
        foreach ($categorias as $categoria) {
            ?>
            <p class="p-categoria">
                <?php echo $categoria[1]; ?>
            </p>
        <?php
        }


        exit;
    }


    if (isset($_GET["verLibros"])) {
        //realizar funcion pintar los libros o cargar algun listado
        $dataBase = new Libros();
        $libros = $dataBase->showLibros();

        ?>
        <h1>Nuestros Libros!!</h1>
        <div class="container">

            <?php
            foreach ($libros as $libro) {

                ?>
                <img class="img-libro" src="<?php echo "img/" . $libro["portada"]; ?>"> </img>
            <?php
            }
            ?>
        </div>

        <div class="menu-filters">
            <h1>Filtros</h1>
            <a href="Public.php?verLibros-filter-a-z" id="filter-a-z"> Ordenar de la A-Z</a>
        </div>
        <?php


        exit;
    }

    if (isset($_GET["verLibros-filter-a-z"])) {
        //realizar funcion pintar los libros o cargar algun listado
        $dataBase = new Libros();
        $filtradosAlafabeticamente = $dataBase->filtrarLibroAlfabeticamente();

        ?>
        <h1>Nuestros Libros!!</h1>
        <div class="container">

            <?php
            foreach ($filtradosAlafabeticamente as $libro) {

                ?>
                <img class="img-libro" src="<?php echo "img/" . $libro["portada"]; ?>"> </img>
            <?php
            }
            ?>
        </div>

        <div class="menu-filters">
            <h1>Filtros</h1>
            <a href="Public.php?verLibros-filter-a-z" id="filter-a-z"> Ordenar de la A-Z</a>
        </div>
        <?php


        exit;
    }

    if (isset($_GET["verAutores"])) {
        $dataBase = new Libros();
        $libros = $dataBase->showLibros();
        ?>
        <h1>Nuestros Autores!!</h1>
        <?php
        foreach ($libros as $libro) {
            ?>
            <p class="p-autores">
                <?php echo $libro["autor"]; ?>
            </p>

            <div class="menu-filters">
                <h1>Filtros</h1>
                <form action="Public.php?verAutoresBusqueda" method="post" enctype="multipart/form-data">

                <input type="text" name="busqueda-autor"/>
                <input class="btn btn-primary" type="submit" name="submit" value="Buscar">

            </div>
        <?php
            
        }

    }

    if (isset($_GET["verAutoresBusqueda"])) {
        $busqueda = $_POST["busqueda-autor"];
        //echo $busqueda;
    //queda revisar la query de los autores por que yo quiero que me muestre el campo autores pero que no se repita por que si por ejemplo tengo 2 autores se repiten en mi parte de mis autores
        $data = ($busqueda);
        $dataBase = new Libros();
        $dataBase->filtrarAutorInput($data);

        $autores = $dataBase->filtrarAutorInput($data);

        ?>
        <h1>Nuestros Autores!!</h1>
        <?php
        foreach ($autores as $autor) {
            ?>
            <p class="p-autores">
                <?php echo "Actualmente los libros que tenemos de " . $autor["autor"] . " son " . $autor["titulo"]; ?>
            </p>

            <div class="menu-filters">
                <h1>Filtros</h1>
                <form action="Public.php?verAutoresBusqueda" method="post" enctype="multipart/form-data">

                <input type="text" name="busqueda-autor" />
                <input class="btn btn-primary" type="submit" name="submit" value="Buscar">

            </div>
        <?php
        }

    }


    ?>

</body>

</html>