<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div class="nuevo">
<form name='ALTA' method="POST" action="index.php?orden=Alta" enctype="multipart/form-data">
Nombre     : <input type="text" name="nombre" value="<?= $nombre ?>"><br>
Director : <input type="text" id="director" name="director" value="<?= $director ?>"><br>
Denero : <input type="text"    name="genero" value = "<?= $genero ?>" ><br>
Trailer : <input type="text"    name="trailer" value = "<?= $trailer ?>" ><br>
Imagen : <input type="file"    name="imagen" value = "<?= $imagen ?>" ><br>

<br>
	<input class="btn green" type="submit" value="Almacenar">
	<input class="btn red" type="button" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>


</div>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>