<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloUserDB {

     private static $dbh = null;
     private static $lista_pelis ="Select * from peliculas limit :inicio,:numpelis";
     private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
     private static $borra_peli= "Delete from peliculas where codigo_pelicula = ?";
     private static $buscar_Nombre =  "Select * from peliculas where nombre = ? ";
     private static $buscar_Director =  "Select * from peliculas where director = ? ";
     private static $buscar_Genero =  "Select * from peliculas where genero = ? ";
     
     private static $insert_peli = "Insert into peliculas (nombre,director,genero,imagen,trailer)".
     " VALUES (?,?,?,?,?)";
     

  /*
   
 private static $update_peli   = "UPDATE peliculas set  codigo_pelicula=?, nombre =?, ".
     "director=?, genero=?, imagen=? where codigo_pelicula = ? ";

   
 */    
     
public static function init(){
   
    if (self::$dbh == null){
        try {
            // Cambiar  los valores de las constantes en config.php
            $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME.";charset=utf8";
            self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
            // Si se produce un error se genera una excepción;
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        
    }
    
}


public static function UserAdd($nuevo):bool{
    $stmt = self::$dbh->prepare(self::$insert_peli);
    $stmt->bindValue(1,$nuevo[0] );
    $stmt->bindValue(2,$nuevo[1] );
    $stmt->bindValue(3,$nuevo[2] );
    $stmt->bindValue(4,$nuevo[3] );
    $stmt->bindValue(5,$nuevo[4] );
    if ($stmt->execute()){
        return true;
    }
    return false;
}

// Tabla de objetos con todas las peliculas
public static function GetAll ():array{
   // Hago una consulta que limita el numero de resultados a 5
    $stmt = self::$dbh->prepare(self::$lista_pelis);
    $numpelis=5;
    if(!isset($_GET['pagina'] ) ||$_GET['pagina']<1){
        $_GET['pagina']=1;
    }
    $inicio = ($_GET['pagina']-1)*$numpelis;
    $tpelis = [];
    $stmt->bindParam(':inicio', $inicio,PDO::PARAM_INT);
    $stmt->bindParam(':numpelis', $numpelis,PDO::PARAM_INT);
    $stmt->execute();
    // Llamo a una funcion para saber el total de peliculas de la base de datos
    $totalpelis= modeloUserDB::GetTotal();
    $totalpelis=count($totalpelis);
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    $array = array($tpelis,$totalpelis);
    /*Devuelvo un array con los resultados de la consulta y 
    con el total de peliculas
    El total de peliculas lo voy a usar para dividirlo entre 5 y asi 
    establecer el numero de paginas*/
    return $array;
}

public static function GetTotal ():array{
    $stmt = self::$dbh->query("select * from peliculas");
    
    $totalpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $totalpelis[] = $peli;
    }
    return $totalpelis;
}



// Datos de una película para visualizar
public static function UserGet ($codigo){
    $datospeli = [];
    $stmt = self::$dbh->prepare(self::$consulta_peli);
    $stmt->bindValue(1,$codigo);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Usuario, pero devuelvo una tabla
        // Para no tener que modificar el controlador
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        $uobj = $stmt->fetch();
        $datospeli = [ 
                     $uobj->codigo_pelicula,
                     $uobj->nombre,
                     $uobj->director,
                     $uobj->genero,
                     $uobj->imagen,
                     $uobj->trailer,

                     ];
        return $datospeli;
    }
    
    return $datospeli;
}

public static function BuscarNombre ($nombre){
    
    $stmt = self::$dbh->prepare(self::$buscar_Nombre);
    $datospeli = [];
    $stmt->bindValue(1,$nombre);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $resu = $stmt->fetch()){
        $datospeli[] = $resu;
    }
    return $datospeli;
}

public static function BuscarDirector ($director){
 
    $stmt = self::$dbh->prepare(self::$buscar_Director);
    $datospeli = [];
    $stmt->bindValue(1,$director);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $resu = $stmt->fetch()){
        $datospeli[] = $resu;
    }
    return $datospeli;
    

}
public static function BuscarGenero ($genero){
    
    $stmt = self::$dbh->prepare(self::$buscar_Genero);
    $datospeli = [];
    $stmt->bindValue(1,$genero);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $resu = $stmt->fetch()){
        $datospeli[] = $resu;
    }
    return $datospeli;
}

public static function modeloFileSave($imagen,$tmpArchivo){
    
    $rutaDestino = "./app/img";
    chmod($rutaDestino, 0777);
    if($tamanoFichero>50000){
        return false;
    }
    if(move_uploaded_file($tmpArchivo,$rutaDestino."/".$imagen)){
    return true;
    }else return false;

}

public static function UserDel($borrapeli){
    $stmt = self::$dbh->prepare(self::$borra_peli);
    $stmt->bindValue(1,$borrapeli);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}


public static function closeDB(){
    self::$dbh = null;
}

} // class
