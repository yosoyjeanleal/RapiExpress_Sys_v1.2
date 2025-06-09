<?php

require_once __DIR__ . '/vendor/autoload.php';




// Establecer idioma por defecto si no está en la sesión
if (!isset($_SESSION['lang'])) {
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['es', 'en'])) {
        $_SESSION['lang'] = $_COOKIE['lang'];
    } else {
        $_SESSION['lang'] = 'es';
    }
}



use RapiExpress\Controllers\FrontController;

$c = preg_replace('/[^a-z]/', '', strtolower($_GET['c'] ?? 'auth'));
$a = preg_replace('/[^a-zA-Z]/', '', ($_GET['a'] ?? 'login'));

$frontController = new FrontController();
$frontController->handle($c, $a);
