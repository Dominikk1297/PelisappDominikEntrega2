<?php
include_once 'app/config.php';
include_once 'app/modeloPeliDB.php'; 

ob_start();
?>
<h2> Buscar </h2>
<form name='Buscar' method="POST" action="index.php?orden=Buscar">
Buscar Por
<select class="peliculas" name="buscarpor">
  <option class="peliculas" value="1" name="nombre">Nombre</option>
  <option class="peliculas" value="2" name="director">Director</option>
  <option class="peliculas" value="3" name="genero">Genero</option>
</select>
<input type="text" name="buscar">

<input type="submit" class="btn orange" value="Buscar">
<input type="button" class="btn red"value=" Volver " size="10" onclick="javascript:window.location='index.php'" >

</form>
<?php 


$contenido = ob_get_clean();
include_once "principal.php";

?>