<?php
include_once 'app/config.php';
include_once 'app/modeloPeliDB.php'; 

ob_start();
$auto = $_SERVER['PHP_SELF'];

?>
<div class="verdetalles">
<div class="detalles">
<img src="app/img/<?=$imagen?>" height="400px" width="250px" >
<h2> Detalles </h2>
<table class="peliculas">
<tr><th>Nombre   </th><td>   <?= $nombre ?></td></tr>
<tr><th>Director </th><td>     <?= $director ?></td></tr>
<tr><th>Genero    </th><td> <?= $genero  ?></td></tr>

</table>
<br>

</div>
<div class="detallestrailer">
<h2>Trailer de la pelicula</h2>
<iframe width="80%" height="315" src="<?= $trailer ?>"></iframe>
</div>
</div>
<center>
<input class="btn red"type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
</center>
<?php 


$contenido = ob_get_clean();
include_once "principal.php";

?>