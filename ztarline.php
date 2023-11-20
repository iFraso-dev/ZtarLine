#!/usr/bin/php
<?php
//
//__ ________                                                  __
//|  \        \                                                |  \
// \▓▓ ▓▓▓▓▓▓▓▓ ______   ______   _______  ______          ____| ▓▓ ______  __     __
//|  \ ▓▓__    /      \ |      \ /       \/      \ ______ /      ▓▓/      \|  \   /  \
//| ▓▓ ▓▓  \  |  ▓▓▓▓▓▓\ \▓▓▓▓▓▓\  ▓▓▓▓▓▓▓  ▓▓▓▓▓▓\      \  ▓▓▓▓▓▓▓  ▓▓▓▓▓▓\\▓▓\ /  ▓▓
//| ▓▓ ▓▓▓▓▓  | ▓▓   \▓▓/      ▓▓\▓▓    \| ▓▓  | ▓▓\▓▓▓▓▓▓ ▓▓  | ▓▓ ▓▓    ▓▓ \▓▓\  ▓▓
//| ▓▓ ▓▓     | ▓▓     |  ▓▓▓▓▓▓▓_\▓▓▓▓▓▓\ ▓▓__/ ▓▓      | ▓▓__| ▓▓ ▓▓▓▓▓▓▓▓  \▓▓ ▓▓
//| ▓▓ ▓▓     | ▓▓      \▓▓    ▓▓       ▓▓\▓▓    ▓▓       \▓▓    ▓▓\▓▓     \   \▓▓▓
// \▓▓\▓▓      \▓▓       \▓▓▓▓▓▓▓\▓▓▓▓▓▓▓  \▓▓▓▓▓▓         \▓▓▓▓▓▓▓ \▓▓▓▓▓▓▓    \▓
//
//
//Created by iFraso-dev
//https://github.com/iFraso-dev/ZtarLine
//Contacts - fraso1989@gmail.com / Fraso@mail.ru
//
error_reporting(0);     // Turn off all error reporting
include 'user_data.php';        //We connect the user_data.php file with user settings
//Getting the application code
$getCode1=file_get_contents("https://id.starline.ru/apiV3/application/getCode?appId=$user_AppId&secret=$user_Secret_md5");
$decgetCode = (json_decode($getCode1, true));
$getCode = ($decgetCode["desc"]["code"]);
$codeToken = md5($user_Secret.$getCode);
$getToken=file_get_contents("https://id.starline.ru/apiV3/application/getToken?appId=$user_AppId&secret=$codeToken");
$decgetTokenCode = (json_decode($getToken, true));
$getTokenCode = ($decgetTokenCode["desc"]["token"]);
//
//User authentication
$loginarr = 'https://id.starline.ru/apiV3/user/login';
$params = array(
    'token' => $getTokenCode,
    'login' => $user_login,
    'pass' => $user_pass,
);
$result = file_get_contents($loginarr, false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($params)
    )
)));
$resultdec = (json_decode($result, true));
//
//User authorization by StarLineID token
$slid_token_url = 'https://developer.starline.ru/json/v2/auth.slid';
$params1 = json_encode(array('slid_token' => $resultdec["desc"]["user_token"]));
$result2 = file_get_contents($slid_token_url, false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $params1
    )
)));
$result3 = get_headers($slid_token_url, false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $params1
    )
)));
$resultdec1 = (json_decode($result2, true));
$expl = explode(" ", $result3['7']);
$pattern = array();
$pattern[0] = '/;+/';
$slnet = preg_replace($pattern, '', $expl["1"]);
$userID1 = $resultdec1["user_id"];
$headers = array(
    'cache-control: max-age=0',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
    'sec-fetch-user: ?1',
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
    'x-compress: null',
    'sec-fetch-site: none',
    'sec-fetch-mode: navigate',
    'accept-encoding: deflate, br',
    'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',

);
//
// Get user_info
$ch1 = curl_init('https://developer.starline.ru/json/v2/user/'.$userID1.'/user_info');
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_ACCEPT_ENCODING, true);
curl_setopt($ch1, CURLOPT_HTTP_CONTENT_DECODING, true);
curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch1, CURLOPT_HEADER, false);
curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch1, CURLOPT_COOKIESESSION, true);
curl_setopt($ch1, CURLOPT_COOKIE, $slnet);
$resalt1 = curl_exec($ch1);
curl_close($ch1);
//
//Get mobile_devices
$ch2 = curl_init('https://developer.starline.ru/json/v1/user/'.$userID1.'/mobile_devices');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_ACCEPT_ENCODING, true);
curl_setopt($ch2, CURLOPT_HTTP_CONTENT_DECODING, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_HEADER, false);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch2, CURLOPT_COOKIESESSION, true);
curl_setopt($ch2, CURLOPT_COOKIE, $slnet);
$resalt2 = curl_exec($ch2);
curl_close($ch2);
//
//Get Device id
$device_id = json_decode($resalt1,true);
$device_id_end = $device_id["devices"][0]["device_id"];
//
// Get obd_params
$ch3 = curl_init('https://developer.starline.ru/json/v1/device/'.$device_id_end.'/obd_params');
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_ACCEPT_ENCODING, true);
curl_setopt($ch3, CURLOPT_HTTP_CONTENT_DECODING, true);
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch3, CURLOPT_HEADER, false);
curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch3, CURLOPT_COOKIESESSION, true);
curl_setopt($ch3, CURLOPT_COOKIE, $slnet);
$resalt3 = curl_exec($ch3);
curl_close($ch3);
//
//Get obd_errors
$ch4 = curl_init('https://developer.starline.ru/json/v1/device/'.$device_id_end.'/obd_errors');
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_ACCEPT_ENCODING, true);
curl_setopt($ch4, CURLOPT_HTTP_CONTENT_DECODING, true);
curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch4, CURLOPT_HEADER, false);
curl_setopt($ch4, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch4, CURLOPT_COOKIESESSION, true);
curl_setopt($ch4, CURLOPT_COOKIE, $slnet);
$resalt4 = curl_exec($ch4);
curl_close($ch4);
//
//JSON output
echo ("{\"user_info\":");
echo ($resalt1);                //Get user_info
echo (",");
echo ("\"mobile_devices\":");
echo ($resalt2);                //Get mobile_devices
echo (",");
echo ("\"obd_params\":");
echo ($resalt3);                // Get obd_params
echo (",");
echo ("\"obd_errors\":");
echo ($resalt4);                //Get obd_errors
echo (",");
echo ("\"creator\":\"Fraso777\",\"link\":\"https://github.com/Fraso777/Starline_in_Zabbix\",\"contacts\":\"fraso1989@gmail.com\"");  //Get creator
echo ("}")
//

?>
