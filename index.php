<?php

declare(strict_types=1);

error_reporting(E_ALL);

use Steampixel\Route;

require_once realpath(__DIR__ . '/vendor/autoload.php');

$cur_dir = explode('\\', __DIR__);

$actual_link = env('APP_URL');
$curPageURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

define('VIEWS', __DIR__ . '/views/');

require_once realpath(__DIR__ . '/routes/routes.php');
Route::run(BASEPATH);