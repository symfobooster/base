<?php

namespace Zabachok\Symfobooster;

use ReflectionClass;

class Hydrator
{
    private $reflectionClassMap;

    public function hydrate($target, array $data)
    {
        $reflection = $this->getReflectionClass($target);
        $object = is_object($target) ? $target : $reflection->newInstanceWithoutConstructor();

        foreach ($data as $name => $value) {
            if (!$reflection->hasProperty($name)) {
                continue;
            }
            $property = $reflection->getProperty($name);

            if (class_exists($property->getType()->getName())) {
                $property->setValue($object, $this->hydrate($property->getType()->getName(), $value));
            } else {
                $setterName = $this->getSetterName($property->getName());
                if ($reflection->hasMethod($setterName)) {
                    $object->{$setterName}($value);
                } else {
                    $property->setValue($object, $value);
                }
            }
        }

        return $object;
    }

    private function getReflectionClass($target): ReflectionClass
    {
        $className = is_object($target) ? get_class($target) : $target;
        if (!isset($this->reflectionClassMap[$className])) {
            $this->reflectionClassMap[$className] = new ReflectionClass($className);
        }
        return $this->reflectionClassMap[$className];
    }

    private function getSetterName(string $property): string
    {
        return 'set' . ucfirst($property);
    }
}
