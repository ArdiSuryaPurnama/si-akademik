<?php

$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
define('BASE_URL', $scriptDir === '/' ? '' : $scriptDir);

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $cleanPath = '/' . ltrim($path, '/');
        if ($cleanPath === '/' && BASE_URL !== '') {
            return BASE_URL . '/';
        }
        return BASE_URL . $cleanPath;
    }
}