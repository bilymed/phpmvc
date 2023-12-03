<?php
declare(strict_types=1);
namespace Lib;

use Lib\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entiries;

    public function get(string $class)
    {
        if (isset($this->entiries[$class])) {
            $entry = $this->entiries[$class];
            return $entry($this);
        }
        return $this->resolve($class);
    }

    public function has(string $class): bool
    {
        return isset($this->entiries[$class]);
    }

    public function set(string $class, callable $callable): void
    {
        $thisentiries[$class] = $callable;
    }

    public function resolve(string $class)
    {
        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException('class "' . $class . '" Is Not Instantiable');
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            // $class = $reflectionClass->newInstance();
            return new $class;
        }

        $constructorParams = $constructor->getParameters();

        if ($constructorParams === null) {
            return new $class;
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if ($type === null || $type instanceof \ReflectionUnionType) {
                return New ContainerException("Params has No Builtin Type");
            }

            if ($type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                return $this->get($type->getName());
            }

            return New ContainerException("Invalid Parameter");

        }, $constructorParams);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}