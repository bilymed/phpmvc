<?php
use App\Controllers\HomeController;
use Lib\App;
use Lib\View;




$app->get("/", [HomeController::class, "index"]);
$app->get("/create", [HomeController::class, "create"]);
$app->post("/create", [HomeController::class, "store"]);


$app->get('/foo', function () {
    return View::make("foo", ['foo' => 'Foo']);
});