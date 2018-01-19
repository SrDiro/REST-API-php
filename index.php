<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="form" action="DBTest_API" method="post">
      <p>ID: </p>
      <input type="text" name="id" placeholder="id">
      <p>Nombre: </p>
      <input type="text" name="id" placeholder="Nombre">
      <p>Descricion: </p>
      <input type="text" name="id" placeholder="Descricion">
      <p>Precio: </p>
      <input type="text" name="id" placeholder="Precio">
      <p>Stock: </p>
      <input type="text" name="id" placeholder="Stock">
    </form>

    <?php
    require_once "DBTest_API.php";
    $DBTest_API = new DBTest_API();
    $DBTest_API->API();
    ?>
  </body>
</html>
