<?php

namespace GraphicEditor\Infrastructure\Component\DependencyInjection;

use GraphicEditor\Infrastructure\Component\DependencyInjection\Exception\DependencyNotFoundException;
use GraphicEditor\Infrastructure\Component\DependencyInjection\Exception\InvalidClassException;

final class Container
{
    /** @var array */
    protected $instances = [];

    public function set($id)
    {
        $this->instances[$id] = $id;
    }

    public function has($id)
    {
        return \array_key_exists($id, $this->instances);
    }

    public function get($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            $this->set($id);
        }

        return $this->resolve($this->instances[$id], $parameters);
    }

    private function resolve($concrete, array $parameters)
    {
        if ($concrete instanceof \Closure) {
            return $concrete($this, $parameters);
        }

        $reflector = new \ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new InvalidClassException(
                \sprintf('Class %s is not instantiable.', $concrete)
            );
        }

        $constructor = $reflector->getConstructor();

        if (\is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function getDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if ($dependency === null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyNotFoundException(
                        \sprintf('Can not resolve class dependency %d', $parameter->name)
                    );
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }
}
