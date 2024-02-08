<!DOCTYPE html>
<html lang="en">
<?php
ob_start();
require("menu.php");
require("CrudUsuarios.php");
include("sesiones/sessionTimer.php");

$dataBase = new Usuarios();
$users = $dataBase->showUsuarios();
?>
<?php
//si el rol es distinto a 33 directamente le digo que no puede acceder
if ($_SESSION["rol"] != 33 ) {
    echo "No puedes acceder aqui!";
    exit;
}

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
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit-formulario {
            width: 300px;
            height: 180px;
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
            var del_buttons = document.querySelectorAll("#del_button");

            console.log(del_buttons);


            for (let i = 0; i < del_buttons.length; i++) {

                del_buttons[i].addEventListener("click", function () {
                    var controlAdmin = this.getAttribute("data-user");
                    if (controlAdmin) {
                        var userDel = this.getAttribute("data-name");
                        if (confirm("¿Quieres eliminar el usuario: " + userDel + " ?")) {
                            var user = this.getAttribute("data-id");

                            location.href = "eliminar.php?id_usuario_del=" + user;

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
                        var user = this.getAttribute("data-id");

                        location.href = "Usuarios.php?id_usuario_edit=" + user;

                    } else {
                        alert("NO TIENES PERMISOS");
                        location.href = "Usuarios.php";
                    }
                });
            }

        }
    </script>
    <title>User Table</title>
</head>

<body>

    <h1 class="h1-main">USUARIOS DE LA LIBRERIA</h1>
    <div class="add-form-container">
        <p class="p-form">AÑADIR USUARIOS</p>

        <div class="add-formulario">

            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <label>Usuario</label>
                <input type="text" name="usuario">
                <br>
                <label>Password</label>
                <input type="text" name="password">
                <br>
                <label>Rol</label>
                <input type="text" name="rol">
                <br>
                <input class="btn btn-primary" type="submit" name="nuevo_usuario" value="Añadir usuario">
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST["nuevo_usuario"])) {

        $usuario = $_POST["usuario"];
        $password = $_POST["password"];
        $pass_md5 = md5($password);

        $rol = $_POST["rol"];


        $data = array($usuario, $pass_md5, $rol);

        $dataBase = new Usuarios();
        $dataBase->addUsuario($data);

        header("location:Usuarios.php");

    }

    if (isset($_GET["id_usuario_edit"])) {

        $id_usuario = $_GET["id_usuario_edit"];

        $data = array($id_usuario);

        $dataBase = new Usuarios();
        $users_editar = $dataBase->UsuarioById($data);

        foreach ($users_editar as $user_editar) {
            $usuario = $user_editar["usuario"];
            $password = $user_editar["password"];
            $rol = $user_editar["rol"];
        }


        //Creo el formulario de edicion 
        ?>
        <div class="edit-form-container">
            <p class="p-form">EDITAR USUARIOS</p>

            <div class="edit-formulario">

                <form action="Usuarios.php?id_usuario_edit=<?php echo $_GET["id_usuario_edit"]; ?>" method="post">
                    <label>Usuario</label>
                    <input type="text" name="usuario" value="<?php echo $usuario ?>">
                    <br>
                    <label>Password</label>
                    <input type="text" name="password" value="<?php echo $password ?>">
                    <br>
                    <label>Rol</label>
                    <input type="text" name="rol" value="<?php echo $rol ?>">
                    <br>
                    <input class="btn btn-primary" type="submit" name="edit_usuario" value="Editar usuario">
                </form>
            </div>
        </div>

        <?php

        if (isset($_POST["edit_usuario"])) {
            $id = $_GET["id_usuario_edit"];
            $usuario = $_POST["usuario"];
            $password = $_POST["password"];
            $pass_md5 = md5($password);
            $rol = $_POST["rol"];


            $data = array($usuario, $pass_md5, $rol, $id);
            $dataBase = new Usuarios();
            $dataBase->editUsuario($data);
            header("location:Usuarios.php");
        }
    }
    ?>
  
    <div class="container mt-4 table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID_Usuario</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>ROL</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($users as $user) { ?>

                    <tr>
                        <td>
                            <?php /*Seria posible crear un input hidden aqui para recoger los datos y luego mostrarlos en el formulario de editar?
                              */echo $user[0];
                            ?>

                        </td>
                        <td>
                            <?php echo $user[1]; ?>

                        </td>
                        <td>
                            <?php echo $user["password"]; ?>
                        </td>
                        <td>
                            <?php echo $user["rol"]; ?>
                        </td>
                        <td>

                            <a class="btn btn-warning btn-sm" id="edit_button" data-id="<?php echo $user[0]; ?>"
                                data-user="<?php echo $controlAdmin; ?>">Editar</a>

                            <a class="btn btn-danger btn-sm" id="del_button" data-id="<?php echo $user[0]; ?>"
                                data-name="<?php echo $user[1]; ?>" data-user="<?php echo $controlAdmin; ?>">Borrar</a>
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