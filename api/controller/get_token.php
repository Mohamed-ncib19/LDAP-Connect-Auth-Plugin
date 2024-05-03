<?php

require_once __DIR__. '/../../config/ldap_config.php';

function getToken($AdminAcess) {
    $username = $AdminAcess['account'];
    $password = $AdminAcess['password'];

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => zentaoApiBaseUrl.'/tokens',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            "account" => $username,
            "password" => $password
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: device=desktop; lang=en; theme=default; '
        ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $responseData = json_decode($response, true);
    
    if ($responseData && isset($responseData['token'])) {
        return $responseData['token'];
    } else {
        return null;
    }
}

?>
