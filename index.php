<?php
header("Content-type: image/png");
require_once "./vendor/autoload.php";

# Dados de acesso:
$url_zabbix = "https://zabbix.com.br";
$user = "*****";
$password = "*****";

$redirect = FALSE;

if( !isset($_GET['d']) ){
    $redirect = TRUE;
}
if( !isset($_GET['i']) || !is_numeric($_GET['i'])){
    $redirect = TRUE;
}
if(!isset($_GET['h']) || !is_numeric($_GET['h'])){
    $redirect = TRUE;
}
if(!isset($_GET['w']) || !is_numeric($_GET['w'])){
    $redirect = TRUE;
}
if(!isset($_GET['e']) || !is_numeric($_GET['e'])){
    $redirect = TRUE;
}

if($redirect){
    header('Location: http://www.google.com.br/');
    return;
}
$day = strval($_GET['d']);
$graphid = $_GET['i'];
$height = $_GET['h'];
$width  = $_GET['w'];
$event  = $_GET['e'];
$from = "now-{$day}";

$file_name = "img/{$graphid}_{$event}.png";
$parans = "?from={$from}&to=now&itemids%5B0%5D={$graphid}&profileIdx=web.item.graph.filter&width={$width}&height={$height}";

$client = new \GuzzleHttp\Client([
    'headers' => [ 'Content-Type' => 'application/json' ]
]);

$response_api = $client->post("$url_zabbix/api_jsonrpc.php",
[
    'json' => [
        'jsonrpc' => '2.0',
        'method' => 'user.login',
        'params' =>  
                     array("user" => $user,
                            "password" => $password),

        'id' => 1,
        'auth' => null,
    ],
]
);

$auth = json_decode($response_api->getBody(), true);
$cookie = 'zbx_sessionid='.$auth['result'];
$response = $client->get($url_zabbix."/chart.php/".$parans,
    [
        'headers' => ['Cookie' => $cookie],
        'stream' => true,
    ]
);

$body =  base64_encode($response->getBody());
file_put_contents($file_name, base64_decode($body));
$im = imagecreatefrompng("$file_name");
imagepng($im);
imagedestroy($im);
?>
