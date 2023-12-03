<?php
declare(strict_types=1);
namespace Lib;

use Lib\Exceptions\RouteNotFoundException;

class App
{
    private $routes = [];
    private $attributes = [];

    public function __construct(private Container $container) {
    }

    public function get(string $route, callable|array $controller, array $params = []): void
    {
        $this->routes['GET'][$route] = $controller;
    }

    public function post(string $route, callable|array $controller): void
    {
        $this->routes['POST'][$route] = $controller;
    }

    public function execute(string $httpRequest, string $httpMethod)
    {
        $route = explode('?', $httpRequest)[0];

        $callable = $this->routes[$httpMethod][$route] ?? null;

        if ($callable === null) {
            throw new RouteNotFoundException();
        }

        if (is_callable($callable)) {
            return call_user_func($callable);
        }

        if (is_array($callable)) {

            [$controller, $action] = $callable;

            if (class_exists($controller)) {

                // $reflectionClass = new \ReflectionClass($controller);
                // $class = $reflectionClass->newInstanceWithoutConstructor();

                // if ($reflectionClass->hasMethod($action)) {
                //     // Use reflection to call the method
                //     $method = $reflectionClass->getMethod($action);
                //     $methodArguments = [new Request()];
        
                //     // If the method has parameters, you might want to provide arguments here
                //     // $methodArguments = [...];
        
                //     return $method->invokeArgs($class, $methodArguments);
                // }
            
                if (class_exists($controller)) {

                    $class =  $this->container->get($controller);

                    if (method_exists($class, $action)) {
                        return call_user_func_array([$class, $action], [new Request()]);
                    }
                }

                
            }
        }
        throw new RouteNotFoundException();
    }
}
