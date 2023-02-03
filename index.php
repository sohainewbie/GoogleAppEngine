<?php

if(isset($_POST)){
    $json = file_get_contents('php://input');
    header('Author: sohay');
    header('Content-Type: application/json');
    if($_SERVER['REQUEST_URI'] === '/v1/rates/couriers'){
        $response = http("https://api.biteship.com/v1/rates/couriers", json_decode($json));
        echo $response;
        die();
    }
    if($_SERVER['REQUEST_URI'] === '/v1/couriers'){
        $response = http("https://api.biteship.com/v1/couriers");
        echo $response;
        die();
    }
}

function http($url, $postdata=NULL) {
    global $env;
    global $config;
    $ch = curl_init();
    $request = ($postdata === NULL ? "" : json_encode($postdata));
    $token = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';
    $headers = [
            'Content-Type: application/json',
            'authorization: '.$token,
            'Content-Length: ' . strlen($request)
    ];
    if(strlen($request)> 0){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Biteship plugin');
    curl_setopt($ch, CURLOPT_TIMEOUT, '30');
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>

<html>
    <pre>

    ,-.       _,---._ __  / \
 /  )    .-'       `./ /   \
(  (   ,'            `/    /|
 \  `-"             \'\   / |
  `.              ,  \ \ /  |
   /`.          ,'-`----Y   |
  (            ;        |   '
  |  ,-.    ,-'         |  /
  |  | (   |  sohay     | /
  )  |  \  `.___________|/
  `--'   `--'
  ~ yari URL apaan sih . . .
    Browser: <?=strip_tags($_SERVER['HTTP_USER_AGENT']);?>
    </pre>
</html>
