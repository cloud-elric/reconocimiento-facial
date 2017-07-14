<?php
include("configuracion.php");
include("Meerkat.php");
include("../conexion/Conexion.php");
include("../conexion/FuncionesBaseDatos.php");

if(isset($_POST['imgBase64']) && isset($_POST['nombre'])){
    $data = $_POST['imgBase64'];
    $nombre = $_POST['nombre'];

    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $idFoto = uniqid();
    $file = '../imagenes/'. $idFoto . '.png';
    $success = file_put_contents($file, $data);

    $urlImage = $baseUrl.'imagenes/'.$idFoto . '.png';

    $conexionBaseDatos = new Conexion();

    $funciones = new FuncionesBaseDatos();
    if($funciones->guardarUsuario($conexionBaseDatos, $nombre, $idFoto)){
         $meerkatApi = new Meerkat($apiKey);
        echo $meerkatApi->guardarUsuario($urlImage, $nombre);
    }else{
        
    }

   
}

