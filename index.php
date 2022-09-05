<?php

declare(strict_types=1);

error_reporting(E_ALL);

use Steampixel\Route;

require_once realpath(__DIR__ . '/vendor/autoload.php');

$cur_dir = explode('\\', __DIR__);

$actual_link = env('APP_URL');
$curPageURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$cur_dir = explode('\\', __DIR__);

define('BASEPATH', "/" . $cur_dir[count($cur_dir) - 1] . "/");
define('VIEWS', __DIR__ . '/views/');
define('CURRENT_PATH', $actual_link);
define('CURRENT_PATH_FULL', $curPageURL);

require_once realpath(__DIR__ . '/routes/routes.php');
Route::run(BASEPATH);