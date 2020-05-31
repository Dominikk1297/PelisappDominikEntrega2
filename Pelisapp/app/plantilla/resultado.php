<?php
include_once 'app/Pelicula.php';


ob_start();
?>
<h2>Resultados de la busqueda</h2>
<table class="peliculas">
<th>Código</th><th>Nombre</th><th>Director</th><th>Genero</th>
<?php foreach ($peliculasbuscar as $resu) : ?>
<tr>		
<td><?= $resu->codigo_pelicula ?></td>
<td><?= $resu->nombre ?></td>
<td><?= $resu->director ?></td>
<td><?= $resu->genero ?></td>
</tr>
<?php endforeach; ?>
</table>
<input type="button" class="btn red" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 


$contenido = ob_get_clean();
include_once "principal.php";

?>