<?php
session_start();

function lang_change() {
    $lang = $_GET['lang'] ?? 'es';
    if (!in_array($lang, ['es', 'en'])) {
        $lang = 'es';
    }
    $_SESSION['lang'] = $lang;
    setcookie('lang', $lang, time() + (365 * 24 * 60 * 60), '/'); // guarda por 1 año
    echo 'ok';
}


