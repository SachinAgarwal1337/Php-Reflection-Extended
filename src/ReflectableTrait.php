<?php namespace SKAgarwal\Reflection;

use ReflectionClass;
use SKAgarwal\Reflection\Exceptions\MethodNotFoundException;
use SKAgarwal\Reflection\Exceptions\ObjectNotFoundException;

/**
 * For easy testing of provate\protected methods
 * For easy testing of provate\protected properties
 *
 * trait ReflectableTrait
 *
 * @package Tests\Traits
 */
trait ReflectableTrait
{
    /**
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Object of the class to be reflected.
     *
     * @var
     */
    protected $classObj;

    /**
     * Check if the dynamic method is called on given type.
     *
     * @param $type
     * @param $name
     *
     * @return int
     */
    private function is($type, $name)
    {
        return preg_match("/{^$type}/", $name);
    }


    /**
     * Extract the dynamic name from given type
     *
     * @param $from
     * @param $name
     *
     * @return string
     */
    private function extract($type, $name)
    {
        return lcfirst(preg_replace("/{$type}/", '', $name, 1));
    }

    /**
     * $classObj and $reflection properties should be defined.
     *
     * @throws ObjectNotFoundException
     */
    private function checkClassObjAndReflectionProperties()
    {
        if (!$this->classObj || !$this->reflection) {
            throw new ObjectNotFoundException("Should be called after 'on()' method.");
        }
    }

    /**
     * check if property or method
     * is private or protected.
     *
     * @param $object ReflectionMethod / ReflectionProperty
     *
     * @return bool
     */
    private function setAccessibleOn($object)
    {
        if ($object->isPrivate() || $object->isProtected()) {
            $object->setAccessible(true);
        }
    }

    /**
     * Getting the reflection.
     *
     * @param $classObj Object of the class the reflection to be created.
     */
    public function reflect($classObj)
    {
        $this->classObj = $classObj;
        $this->reflection = new ReflectionClass($classObj);
    }

    /**
     * Getting the reflection.
     *
     * @param $classObj Object of the class the reflection to be created.
     *
     * @return $this
     */
    public function on($classObj)
    {
        $this->reflect($classObj);

        return $this;
    }

    /**
     * Call to public/private/protected methods.
     *
     * @param       $method    Method name to be called (case sensitive)
     * @param array $arguments Arguments to be passed to the method
     *
     * @return $this
     * @throws ObjectNotFoundException
     */
    public function call($method, $arguments = [])
    {
        $this->checkClassObjAndReflectionProperties();

        $method = $this->reflection->getMethod($method);
        $this->setAccessibleOn($method);
        $method->invokeArgs($this->classObj, $arguments);

        return $this;
    }

    /**
     * Get value of public/private/protected properties.
     *
     * @param $name Property name to be accessed (Case sensitive).
     *
     * @return mixed
     */
    public function get($name)
    {
        $property = $this->reflection->getProperty($name);
        $this->setAccessibleOn($property);

        return $property->getValue($this->classObj);
    }

    /**
     * Set value of public/private/protected properties.
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $property = $this->reflection->getProperty($name);
        $this->setAccessibleOn($property);

        $property->setValue($this->classObj, $value);
    }

    /**
     * @param       $method
     * @param array $arguments
     *
     * @return ReflectableTrait
     * @throws MethodNotFoundException
     * @throws ObjectNotFoundException
     */
    public function __call($method, $arguments = [])
    {
        if ($this->is('call', $method)) {
            $methodName = $this->extract('call', $method);

            return $this->call($methodName, $arguments);
        }

        throw new MethodNotFoundException("Method '{$method}' is not defined.");
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->is('get', $name)) {
            $name = $this->extract('get', $name);

            return $this->get($name);
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if($this->is('set', $name)){
            $name = $this->extract('set', $name);

            return $this->set($name, $value);
        }
    }
}
