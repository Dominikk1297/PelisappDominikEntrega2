<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlPeliInicio(){
   }

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta (){

    $nombre = "";
    $director = "";
    $genero = "";
    $imagen = "";
    $trailer = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['nombre']) && isset($_POST['director']) && isset($_POST['genero']) && isset($_POST['trailer'])) { 
            $nombre = $_POST['nombre'];
            $director = $_POST['director'];
            $genero= $_POST['genero'];
            $trailer= $_POST['trailer'];
            
            if(isset($_FILES['imagen'])){     
            $imagen=$_FILES['imagen']['name'];
            $tmpArchivo=$_FILES['imagen']['tmp_name'];
            if(modeloUserDB::modeloFileSave($imagen,$tmpArchivo,$tamanoFichero)==false){
                 $imagen="defecto.jpg";
            }

            }else $imagen="defecto.jpg";
          
            
            $nuevo = [     
                $nombre,
                $director,
                $genero,
                $imagen,
                $trailer,
            ];
            
            
    
        }
        modeloUserDB::UserAdd($nuevo);
        modeloUserDB::GetAll();
        header('Location:index.php?orden=VerPelis');

    } else {
        include_once 'plantilla/fnuevo.php';
    }




}
/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliBuscar (){
    $buscarpor="";
    
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $buscarpor = $_POST['buscarpor'];
        
        Switch( $buscarpor )
        {
            case 1:
                
                if (isset($_POST['buscar'])) {
                    $buscar = $_POST['buscar'];
                    
                    $peliculasbuscar=modeloUserDB::BuscarNombre($buscar);
                    
                }
                include_once 'plantilla/resultado.php';
                break;
                
            case 2:
                
                 if (isset($_POST['buscar'])) {
                    $buscar = $_POST['buscar'];
                    
                    $peliculasbuscar=modeloUserDB::BuscarDirector($buscar);
                    
                }
                include_once 'plantilla/resultado.php';
                break;
                
                
            case 3:
                
                if (isset($_POST['buscar'])) {
                    $buscar = $_POST['buscar'];
                    
                    $peliculasbuscar=modeloUserDB::BuscarGenero($buscar);
                    
                }
                include_once 'plantilla/resultado.php';
                break;
                
                
        }
        
        
    } else {
        include_once 'plantilla/fbuscarpeli.php';
    }
    
    
}


/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles(){

        $clave=$_GET['codigo'];
        $listadetalles = ModeloUserDB::UserGet($clave);
        $nombre=$listadetalles[1];
        $director=$listadetalles[2];
        $genero=$listadetalles[3];
        $imagen=$listadetalles[4];
        $trailer=$listadetalles[5];
       
        include_once 'plantilla/detalle.php'; 
    
    
    
}



/*
 * Borrar Peliculas
 */

function ctlPeliBorrar(){

    $borrapeli = $_GET['userid'];
    modeloUserDB::UserDel($borrapeli);
    modeloUserDB::GetAll();
    header('Location:index.php?orden=VerPelis');

    
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloUserDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlPeliVerPelis (){
    // Obtengo los datos del modelo
    $peliculas = ModeloUserDB::GetAll()[0]; 
    $totalpelis = ModeloUserDB::GetAll()[1];
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
   
}
