<?php
use App\Controllers\HomeController;
use App\Repositories\HomeRepository;
use Lib\App;
use Lib\Container;
const BASEPATH = __DIR__ . '/../';
const VIEWPATH = __DIR__ . '/../app/views/';
const BASECONTROLLERS = BASEPATH . 'app/controllers/';

require_once BASEPATH . "/vendor/autoload.php";

session_start();
$container = new Container();
$app = new App($container);

include_once(BASEPATH . '/app/routes.php');

echo $app->execute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
