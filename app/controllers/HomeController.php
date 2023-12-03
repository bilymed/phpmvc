<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Repositories\HomeRepository;
use App\Repositories\ProductRepository;
use Lib\Container;
use Lib\Request;
use Lib\View;

class HomeController
{

    public function __construct(private HomeRepository $repository)
    {
    }

    public function index(Request $request): View
    {
       var_dump($request->all());

        return View::make("home/index", ['foo' => 'bar']);
    }

    public function create(): View
    {
        return View::make("home/create", []);
    }

    public function store(Request $request)
    {
        var_dump($request->get('value'));
    }
}