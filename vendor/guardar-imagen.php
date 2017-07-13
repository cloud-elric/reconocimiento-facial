<?php

if(isset($_POST['imgBase64'])){
    $data = $_POST['imgBase64'];

    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $idFoto = uniqid();
    $file = '../imagenes/'. $idFoto . '.png';
    $success = file_put_contents($file, $data);

    

}

