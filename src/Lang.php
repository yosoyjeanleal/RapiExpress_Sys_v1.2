<?php
namespace RapiExpress;

class Lang {
    public static function get(string $key): string {
        $lang = $_SESSION['lang'] ?? 'es';
        $file = __DIR__ . "/../lang/{$lang}.php";
        if (!file_exists($file)) return $key;
        $translations = include $file;
        return $translations[$key] ?? $key;
    }

    public static function set(string $lang): void {
        $_SESSION['lang'] = $lang;
    }
}
