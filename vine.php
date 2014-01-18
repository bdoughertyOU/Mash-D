<?php
$username = 'jillianmyla@aol.com';
$password = 'glennn11';

$key = vineAuth($username,$password);

$userId = strtok($key,'-');


$records = vineTimeline($userId,$key);
var_dump($records);

function vineAuth($username,$password)
{
        $loginUrl = "https://vine.co/api/users/authenticate";
        $username = urlencode($username);
        $password = urlencode($password);
        $token = sha1($username); // I believe this field is currently optional, but always sent via the app
        
        $postFields = "username=$username&password=$password"; 


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch));

        if (!$result)
        {
                curl_error($ch);
        }
        else
        {
                // Key aLso contains numeric userId as the portion of the string preceding the first dash
                return $result->data->key; 
        }

        curl_close($ch);
}

function vineTimeline($userId,$key)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = 'https://vine.co/api/timelines/graph';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('vine-session-id: '.$key));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}
?>