<?php

require_once __DIR__ . '/../../config/ldap_config.php';

function checkUser($token, $name,$password) {

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => zentaoApiBaseUrl.'/users/'.$name,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Cookie: device=desktop; lang=en; theme=default; zentaosid=' . $token,
        'Authorization: ' . $token
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $responseData = json_decode($response,true);
    if($responseData && isset($responseData['id'])){
        $data = array(
            "account" => $name,
            "password" => $password
        );
        $checkLogin = getToken($data);
        if($checkLogin){
            return true;
        }else{
            return  array(
                'status' => 'error',
                'message' => 'failed to get token'
            );
        }
    }else{
        return  array(
            'status' => 'error',
            'message' => 'User does not exist in Zentao'
        );
    }
    
    
}

?>
