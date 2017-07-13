<?php

if(isset($_POST['imgBase64'])){
    $data = $_POST['imgBase64'];

    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $idFoto = uniqid();
    $file = '../imagenes/'. $idFoto . '.png';
    $success = file_put_contents($file, $data);

    $ch = curl_init("https://demo.meerkat.com.br/frapi_demo/info/people");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // if (!empty($headers)) {
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // }
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: 81846eb7d66fd8e421c9f474fff89535']);

        $content = curl_exec($ch);

        curl_close($ch);
echo $content;
    
    

}

