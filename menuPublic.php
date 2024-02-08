<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/bootstrap.css" type="text/css">

</head>
<style>
    body{
  margin: 0;
  padding: 0;
  font-family: 'Arial', sans-serif;
}

.menu {
  text-align: right;
}
.menu-toggle {
  display: none;
  cursor: pointer;
}

.navbar {
  background-color: #333;
  padding: 15px;
  text-align: right;
}

.menu {
  margin: 0;
  padding: 0;
}

.menu li {
  display: inline-block;
  margin-left: 20px;
}

.menu a {
  text-decoration: none;
  color: white;
  font-size: 16px;
}

</style>
<body>
  <nav class="navbar">
    <ul class="menu">
      <li><a href="Public.php?verCategorias">Categorias</a></li>
      <li><a href="Public.php?verLibros">Libros</a></li>
      <li><a href="Public.php?verAutores">Autores</a></li>
      <li><a href="Login.php">Backend</a></li>
    </ul>
  </nav>


</body>
</html>