<!DOCTYPE html>
<html lang="en">
<?php
ob_start();
require("menu.php");
require("CrudLibros.php");
require("CrudCategorias.php");
require("CrudUsuarios.php");
include("sesiones/sessionTimer.php");



$dataBase = new Libros();
$libros = $dataBase->showLibros();

$dataBaseCategorias = new Categorias();
$categorias = $dataBaseCategorias->showCategorias();

?>
<?php

if (isset($_SESSION["usuario"])) {
    ?>
    <p class="user">Bienvenido :<?php echo " " . $_SESSION["usuario"]; ?>
    </p>
    <?php

$dataBase = new Usuarios();
$UsersMax = $dataBase->UsuarioPermissions();
//user max son los usuarios que me devuelven la query que buscan el rol al que yo quiero dar los permisos de admin

  foreach ($UsersMax as $UserMax){
    //echo $UserMax[0]; //me devuelve el listado de usuario con el rol con permisos
    //echo "</br>";
    if ($_SESSION["usuario"] == $UserMax[0]){
        $controlAdmin = true;
        break;
    } else {
        $controlAdmin = false;
    }
}

}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        /* Center the table */

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .table-container {
            justify-content: center;
            align-items: center;
        }

        .p-form {
            padding-left: 5px;
        }

        .h1-main {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Playfair Display', serif;
        }

        /*div/cajas que tienen dentro el form*/

        .add-form-container {
            width: 400px;
            height: 180px;
            padding-left: 5px;
            margin-bottom: 120px;
            justify-content: center;
            float: left;
        }

        .edit-form-container {
            width: 400px;
            height: 180px;
            padding-left: 5px;
            margin-bottom: 50px;
            margin-left: 5px;
            justify-content: center;
            float: left;
        }

        /*Contenido de los formularios */
        .add-formulario {
            width: 400px;
            height: 250px;
            border: 1px solid lightgray;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;


        }

        .edit-formulario {
            width: 400px;
            height: 250px;
            border: 1px solid lightgrey;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .user {
            text-align: right;
            margin-right: 15px;
        }
    </style>


    <script>

        window.onload = function () {
            //control de admin solo puede borrar
            var del_buttons = document.querySelectorAll("#del_button");

            console.log(del_buttons);

            for (let i = 0; i < del_buttons.length; i++) {

                del_buttons[i].addEventListener("click", function () {
                    var controlAdmin = this.getAttribute("data-user");

                    if (controlAdmin) {
                        var libroDel = this.getAttribute("data-name");
                        if (confirm("¿Quieres eliminar el libro: " + libroDel + " ?")) {
                            var libro = this.getAttribute("data-id");

                            location.href = "eliminar.php?id_libro_del=" + libro;

                        } else {
                            // Si el usuario cancela, no hace nada
                            alert("No has eliminado");
                        }

                    } else {
                        alert("NO TIENES PERMISOS");

                    }
                });
            }

            var edit_buttons = document.querySelectorAll("#edit_button");


            for (let i = 0; i < edit_buttons.length; i++) {

                edit_buttons[i].addEventListener("click", function () {
                    var controlAdmin = this.getAttribute("data-user");

                    if (controlAdmin) {
                            var libro = this.getAttribute("data-id");

                            location.href = "Libros.php?id_libro_edit=" + libro;

                    } else {
                        alert("NO TIENES PERMISOS");
                        location.href = "Libros.php";
                    }
                });
            }

        }


    </script>

    <title>User Table</title>
</head>


<body id="body">

    <h1 class="h1-main">LIBROS DE LA LIBRERIA</h1>
    <div class="add-form-container">
        <p class="p-form">FORMULARIO PARA AÑADIR LIBROS</p>

        <div class="add-formulario">

            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <label>Titulo</label>
                <input type="text" name="titulo">
                <br>
                <label>Portada</label>
                <input type="file" name="portada">
                <br>
                <label>Autor</label>
                <input type="text" name="autor">
                <br>
                <label>Categoria</label>
                <select name="categoria">
                    <?php
                    //accedemos a la base de datos de categorias con $categorias y la recorremos, como queremos mostrar las categorias que hay hacemos un foreach y indicamos la posicion que queremos mostrar
                    foreach ($categorias as $categoria) {
                        ?>
                        <option value="<?php echo $categoria[0]; ?>">
                            <?php echo $categoria[1]; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <br>
                <label>Precio</label>
                <input type="text" name="precio">
                <br>
                <input class="btn btn-primary" type="submit" name="nuevo_libro" value="Añadir libro">
            </form>
        </div>
    </div>

    <?php

    if (isset($_POST["nuevo_libro"])) {
        $titulo = $_POST["titulo"];

        $portada = $_FILES['portada']['name'];

        if (file_exists("img/" . $_FILES['portada']['name'])) {
            $_FILES['portada']['name']. " Ya existe. ";
            header("location:Libros.php");
            exit;
        }else{
            move_uploaded_file($_FILES['portada']['tmp_name'],"img/" . $_FILES['portada']['name']);
            }

            if ($_FILES['portada']['name'] == ""){
                
                echo "Campo portada vacio";
                sleep(1);
                header("location:Libros.php");
                exit;
            }

        $autor = $_POST["autor"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];

        $data = array($titulo,$portada,$autor, $categoria, $precio);

        $dataBase = new Libros();

        $dataBase->addLibro($data);

        header("location:Libros.php");

    }
    

    if (isset($_GET["id_libro_edit"])) {
        $id_libro = $_GET["id_libro_edit"];

        $data = array($id_libro);

        $dataBase = new Libros();
        $libros_editar = $dataBase->LibroById($data);

        foreach ($libros_editar as $libro_editar) {
            $titulo = $libro_editar["titulo"];
            $autor = $libro_editar["autor"];
            $precio = $libro_editar["precio"];
            //falta recoger campo categoria
    
        }


        //Creo el formulario de edicion 
        ?>
        <div class="edit-form-container">
            <p class="p-form">EDITAR LIBROS</p>

            <div class="edit-formulario">
                <form action="Libros.php?id_libro_edit=<?php echo $_GET["id_libro_edit"]; ?>" method="post" enctype="multipart/form-data">
                    <label>Titulo</label>
                    <input type="text" name="titulo" value="<?php echo $titulo ?>">
                    <br>
                    <label>Portada</label>
                    <input type="file" name="portada">
                    <br>
                    <label>Autor</label>
                    <input type="text" name="autor" value="<?php echo $autor ?>">
                    <br>
                    <label>Categoria</label>
                    <select name="categoria">
                        <?php
                        //accedemos a la base de datos de categorias con $categorias y la recorremos, como queremos mostrar las categorias que hay hacemos un foreach y indicamos la posicion que queremos mostrar
                        foreach ($categorias as $categoria) {
                            ?>
                            <option value="<?php echo $categoria[0]; ?>">
                                <?php echo $categoria[1]; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <br>
                    <label>Precio</label>
                    <input type="text" name="precio" value="<?php echo $precio ?>">
                    <br>
                    <input class="btn btn-primary" type="submit" name="edit_libro" value="Editar libro">
                </form>
            </div>
        </div>

        <?php

        if (isset($_POST["edit_libro"])) {

            $titulo = $_POST["titulo"];
            $portada = $_FILES['portada']['name'];

            //control de si la portada existe que no se pueda modificar
            if (file_exists("img/" . $_FILES['portada']['name'])) {
            $_FILES['portada']['name']. " Ya existe. ";
            }else{
            move_uploaded_file($_FILES['portada']['tmp_name'],"img/" . $_FILES['portada']['name']);
            }
            
            $autor = $_POST["autor"];
            $categoria = $_POST["categoria"];
            $precio = $_POST["precio"];
            $id = $_GET["id_libro_edit"];

            $data = array($titulo,$portada,$autor, $categoria, $precio, $id);

            $dataBase = new Libros();

            $dataBase->editLibro($data);

            header("location:Libros.php");
        }
    }
    ?>

    <div class="container mt-4 table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID_Libro</th>
                    <th>Titulo</th>
                    <th>Portada</th>

                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro) { ?>

                    <tr>
                        <td>
                            <?php /*Seria posible crear un input hidden aqui para recoger los datos y luego mostrarlos en el formulario de editar?
                              */echo $libro[0];
                            ?>

                        </td>
                        <td>
                            <?php echo $libro[1]; ?>

                        </td>
                        <td>
                            <img height="100px" width="80px" src="<?php echo "img/".$libro[2]; ?>"   > 
                        </td>
                        <td>
                            <?php echo $libro[3]; ?>
                        </td>
                        <td>
                            <?php echo $libro[6]; ?>
                        </td>
                        <td>
                            <?php echo $libro[5] . "€"; ?>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" id="edit_button" data-id="<?php echo $libro[0];?>"
                                data-user="<?php echo $controlAdmin; ?>">Editar</a>

                            <a class="btn btn-danger btn-sm" id="del_button" data-id="<?php echo $libro[0];?>"
                                data-name="<?php echo $libro["titulo"]; ?>"
                                data-user="<?php echo $controlAdmin; ?>">Borrar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>