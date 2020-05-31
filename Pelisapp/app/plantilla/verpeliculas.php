<?php
include_once 'app/Pelicula.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];
$numpaginas=ceil($totalpelis/5); 
if (!isset($_GET["pagina"])){
    header('location:index.php?pagina=1');
}
if ($_GET["pagina"]>$numpaginas || $_GET["pagina"]<1){
    header('location:index.php?pagina=1');
}



?>


<table class="peliculas">
<th>Código</th><th>Nombre</th><th>Director</th><th>Genero</th>
<?php foreach ($peliculas as $peli) : ?>
<tr>		
<td><?= $peli->codigo_pelicula ?></td>
<td><?= $peli->nombre ?></td>
<td><?= $peli->director ?></td>
<td><?= $peli->genero ?></td>
<td><a href="#"
			onclick="confirmarBorrar('<?= $peli->nombre."','".$peli->codigo_pelicula."'"?>);">Borrar</a></td>
<td><a href="<?= $auto?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula?>">Detalles</a></td>
</tr>
<?php endforeach;  ?>


</table>
<br>
<div class="botones">
<form name='f2' action='index.php'>
<input type='hidden' name='orden' value='Alta'> 
<input class="btn green" type='submit' value='Nueva Película' >
</form>
<form  name='f2' action='index.php'>
<input type='hidden' name='orden' value='Buscar'> 
<input  class="btn orange" type='submit' value='Buscar Película' >
</form>
</div><br>

<?php 

    ?><table id="paginas"><tr><td class="pag"><a href="index.php?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></td><?php 
    for($i=0;$i<$numpaginas;$i++){?>
    <td class="pag"><a href="index.php?pagina=<?php echo $i+1?>">
    <?= $i+1?>
   </a></td>
   
    
<?php }?>
 <td class="pag"><a href="index.php?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></td></tr></table>







<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>