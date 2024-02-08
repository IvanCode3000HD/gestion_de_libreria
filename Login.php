<script>

window.onload = function (){
let button = document.getElementById("button");

button.addEventListener("click",function () { 

    button.setAttribute("value","");
    button.className = "spinner-border m-5";

});
}


</script>
<?php
require("CrudUsuarios.php");

$dataBase = new Usuarios();
$users = $dataBase->showUsuarios();

//recorremos nuestra base de datos donde tenemos los users con sus pass
foreach ($users as $user) {
    $usuario_bd = $user["usuario"];
    $password_bd = $user["password"];
    $rol = $user["rol"];

//enviamos el formulario con los campos, estos tienen que ser iguales que los de
//la BBDD si no no entrara en la condicion
if (isset($_POST["enviar"])){

    $usuario = $_POST["usuario"];
    $pass = $_POST["password"];
    
    $pass_md5=md5($pass);


    //echo $pass;
    //echo $pass_md5;

    if ($usuario == $usuario_bd && $pass_md5 == $password_bd) {
        sleep(1);
     session_start();
     $_SESSION["usuario"] = $usuario;
        //creo contador
        $_SESSION["activo"] = true;
        $_SESSION["lastActivity"] = date("Y-n-j H:i:s");
        //fin contador
        //recojo el rol para luego dar permisos (tambien lo hago con otra query) 
        $_SESSION["rol"] = $rol;

        //si el rol es distinto a 33 (mi admin) entonces le hago el header a otro lado que no sea usuarios por que no quiero que lo vea
        if ($_SESSION["rol"] != 33){
            header("location:Categorias.php");
            exit;
        }
        header("location:Usuarios.php");
    } 
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>LOGIN</title>
</head>


<style>

input{
    margin-top: 15px;
    margin-left: 5px;
}
p{
    text-align: center;
    margin-top: 15px;
    margin-left: 5px;
    font-family: cursive;
}
#pass{
    text-align: center;
    margin-top: 15px;
    margin-left: 5px;
    font-family: cursive;
    color: red;

}
.contenedor {
    margin-top: 10px;
    display: flex;
    justify-content: center;
}

.login-form{
    width: 400px;
    height: 200px;
    border: 2px solid black;
    border-radius: 15px;
    text-align: center;
    padding-left: 15px;
    padding-right: 15px;

}

h1{
    margin-top: 100px;
    text-align: center;
}



</style>    
<body>
<h1>Login</h1>    
<div class="contenedor">

    <div class="login-form">
        <form method="post"action="<?php echo $_SERVER['PHP_SELF'];?>">

    <input type="text" name="usuario" class="form-control" value="<?php if(isset($_COOKIE["usuario"])){ echo $_COOKIE["usuario"];} ?>" placeholder="Usuario">

    <input type="password"  name="password"class="form-control" value="<?php if(isset($_COOKIE["password"])){$_COOKIE["password"];} ?>"placeholder="Contraseña">


    <input id="button" class="btn btn-primary" type="submit"  name="enviar" value="Enviar">

    </form>
    </div>
</div>    

    <?php
    
//cerrar sesion

if (isset($_GET["noSession"])) {
        session_start();
        echo "<p>Hasta pronto: ". $_SESSION["usuario"];"</p>";
        session_destroy();
        unset($_SESSION["usuario"]);

        //verfica que la sesion esta sin setear y redirige al login
        if (empty($_SESSION["usuario"])){
            //usamos el url en vez de location por que si no al aplicar el refresh dentro del header no funciona
            header("refresh: 1; url=Login.php");
        }


}



//crear validaciones en el formulario
if (isset($_POST["enviar"])){
    sleep(1);

        if ($_POST["usuario"] != $usuario_bd && $_POST["password"] != $password_bd){
            ?><p>INTRODUZCA UN USUARIO Y CONTRASEÑA CORRECTA PORFAVOR</p>;<?php
        }  
}
?>


</body>
</html>