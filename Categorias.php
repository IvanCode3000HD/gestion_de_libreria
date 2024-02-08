<!DOCTYPE html>
<html lang="en">
<?php
ob_start();
require("menu.php");
require("CrudCategorias.php");
require("CrudUsuarios.php");
include("sesiones/sessionTimer.php");


$dataBase = new Categorias();
$categorias = $dataBase->showCategorias();
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

 
  /*foreach ($UsersMax as $UserMax){
    //echo $UserMax[0]; //me devuelve el listado de usuario con el rol con permisos
    //echo "</br>";
    if ($_SESSION["usuario"] == $UserMax[0]){
        $controlAdmin = true;
        break;
    } else {
        $controlAdmin = false;
    }
}*/

if ($_SESSION['rol'] == 33){
    $controlAdmin = true;
} else {
    $controlAdmin = false;
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
            width: 300px;
            height: 180px;
            padding-left: 5px;
            margin-bottom: 50px;
            justify-content: center;
            float: left;

        }

        .edit-form-container {
            width: 300px;
            height: 180px;
            padding-left: 5px;
            margin-bottom: 50px;
            margin-left: 5px;
            justify-content: center;
            float: left;

        }

        /*Contenido de los formularios */
        .add-formulario {
            width: 300px;
            height: 180px;
            border: 1px solid lightgray;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        }

        .edit-formulario {
            width: 300px;
            height: 180px;
            border: 1px solid lightgrey;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .user {
            text-align: right;
            margin-right: 15px;
        }
    </style>

    <script>

        window.onload = function () {
            var del_buttons = document.querySelectorAll("#del_button");

            console.log(del_buttons);

            for (let i = 0; i < del_buttons.length; i++) {

                del_buttons[i].addEventListener("click", function () {
                    var catDel = this.getAttribute("data-name");
                    if (confirm("¿Quieres eliminar la categoria " + catDel + " ?")) {
                        var cat = this.getAttribute("data-id");

                        location.href = "eliminar.php?id_categoria_del=" + cat;
                    } else {
                        // Si el usuario cancela, no hace nada
                        alert("No has eliminado");
                    }
                });
            }

            var edit_buttons = document.querySelectorAll("#edit_button");

            for (let i = 0; i < edit_buttons.length; i++) {

                edit_buttons[i].addEventListener("click", function () {
                    var controlAdmin = this.getAttribute("data-user");

                    if (controlAdmin) {
                        var cat = this.getAttribute("data-id");

                        location.href = "Categorias.php?id_categoria_edit=" + cat;

                    } else {
                        alert("NO TIENES PERMISOS");
                        location.href = "Categorias.php";
                    }
                });
            }
        }

    </script>

    <title>Categoria Table</title>
</head>


<body>

    <h1 class="h1-main">CATEGORIAS DE LA LIBRERIA</h1>
    <div class="add-form-container">
        <p class="p-form">AÑADIR CATEGORIA</p>

        <div class="add-formulario">

            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <label>Categoria</label>
                <input type="text" name="categoria">
                <br>
                <input class="btn btn-primary" type="submit" name="nueva_categoria" value="Añadir categoria">
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST["nueva_categoria"])) {
        $categoria = $_POST["categoria"];

        $data = array($categoria);

        $dataBase = new Categorias();
        $dataBase->addCategoria($data);

        header("location:Categorias.php");
    }

    if (isset($_GET["id_categoria_edit"])) {

        $id_categoria = $_GET["id_categoria_edit"];

        $data = array($id_categoria);

        $dataBase = new Categorias();
        $categorias_editar = $dataBase->CategoriaById($data);

        foreach ($categorias_editar as $categoria_editar) {
            $categoria = $categoria_editar["categoria"];
        }

        //Creo el formulario de edicion 
        ?>
        <div class="edit-form-container">
            <p class="p-form">EDITAR CATEGORIA</p>

            <div class="edit-formulario">

                <form action="Categorias.php?id_categoria_edit=<?php echo $_GET["id_categoria_edit"]; ?>" method="post">
                    <label>Categoria</label>

                    <input type="text" name="categoria" value="<?php echo $categoria ?>">
                    <br>

                    <input class="btn btn-primary" type="submit" name="edit_categoria" value="Editar categoria">
                </form>
            </div>
        </div>
        <?php

        ?>
        <?php

        if (isset($_POST["edit_categoria"])) {

            //recoger variables ocultas para mostrarlas en el campo text
            $categoria = $_POST["categoria"];

            $id = $_GET["id_categoria_edit"];

            $data = array($categoria, $id);
            //print_r ($data);
            $dataBase = new Categorias();
            $dataBase->editCategoria($data);

            header("location:Categorias.php");

        }
    }

    ?>

    <div class="container mt-4 table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID_Categoria</th>
                    <th>Categoria</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) { ?>
                    <tr>
                        <td>
                            <?php /*Seria posible crear un input hidden aqui para recoger los datos y luego mostrarlos en el formulario de editar?
                              */echo $categoria[0];
                            ?>
                        </td>
                        <td>
                            <?php echo $categoria[1]; ?>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" id="edit_button" data-id="<?php echo $categoria[0]; ?>"
                                data-user="<?php echo $controlAdmin; ?>">Editar</a>
                            <a class="btn btn-danger btn-sm" id="del_button" data-id="<?php echo $categoria[0]; ?>"
                                data-name="<?php echo $categoria[1]; ?>" data-user="<?php echo $controlAdmin; ?>">Borrar</a>
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