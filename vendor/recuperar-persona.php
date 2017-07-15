<?php
include("configuracion.php");
include("Meerkat.php");
include("../conexion/Conexion.php");
include("../conexion/FuncionesBaseDatos.php");
if(isset($_POST['imgBase64'])){
    $data = $_POST['imgBase64'];
    

    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $idFoto = uniqid();
    $file = '../imagenes-comparar/'. $idFoto . '.png';
    $success = file_put_contents($file, $data);

    $urlImage = $baseUrl.'imagenes-comparar/'.$idFoto . '.png';

    $conexionBaseDatos = new Conexion();
    $conexion = $conexionBaseDatos->openConexion();

     $funciones = new FuncionesBaseDatos();

    $meerkatApi = new Meerkat($apiKey);
    $resultado = json_decode ( $meerkatApi->reconocerUsuario($urlImage, $nombre));
    $usuario = false;
    header('Content-Type: application/json');
    $usuarioEncontrado['status'] = "No encontrado";
    foreach($resultado as $persona){
        if(!$usuario){
            foreach($persona as $datos){
                $token = $datos->recognition->predictedLabel;
                $usuario = true;

                $usuarioEncontrado = $funciones->getUsuario($conexion, $token);
                    
                
            }
        } 
    }
    echo json_encode($usuarioEncontrado);

    exit;
   

    // if($funciones->getUsuario($conexion, )){
    
    // }
}

