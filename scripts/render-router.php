<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$file = realpath(__DIR__.'/../public'.$path);
$publicPath = realpath(__DIR__.'/../public');

if ($file && $publicPath && str_starts_with($file, $publicPath) && is_file($file)) {
    return false;
}

require __DIR__.'/../public/index.php';
