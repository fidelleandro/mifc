<?php 
$url = parse_url($_SERVER['REQUEST_URI']);
$route = explode('/',$url['path']);
$route = array_map('strtolower', $route);//convertir en minusculas los values del array
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$route[1] = strtolower($_SERVER['SERVER_NAME']) == 'localhost' ? $protocolo.'://'.$_SERVER['SERVER_NAME'].'/'.$route[1] : $protocolo.'://'.$_SERVER['SERVER_NAME'];
define("BASE_URL", $route[1]); 
unset($route[0]);
unset($route[1]);
print_r($route); exit;

if ($url != '/') {
    parse_str($url['query']);
    echo $id;
    echo $othervar;
}