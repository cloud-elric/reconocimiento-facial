<?php
include("configuracion.php");
include("Meerkat.php");
if(isset($_POST['imgBase64'])){
    $data = $_POST['imgBase64'];
    

    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $idFoto = uniqid();
    $file = '../imagenes-comparar/'. $idFoto . '.png';
    $success = file_put_contents($file, $data);

    $urlImage = $baseUrl.'imagenes-comparar/'.$idFoto . '.png';

    $meerkatApi = new Meerkat($apiKey);
    echo $meerkatApi->reconocerUsuario($urlImage, $nombre);
}

