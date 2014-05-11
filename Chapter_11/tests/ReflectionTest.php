<?php

class ReflectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $object
     * @param string $methodName
     * @return mixed
     * @throws Exception
     */
    protected function callPrivate($object, $methodName /*, $arg1, $arg2, ... */)
    {
        if (!is_object($object))
        {
            throw new Exception("{$object} is not an object");
        }

        if (!method_exists($object, $methodName))
        {
            throw new Exception(get_class($object)." has no method ".$methodName);
        }

        $args = array_slice(func_get_args(), 2);
        $method = new ReflectionMethod($object, $methodName);
        $method->setAccessible(TRUE);

        return $method->invokeArgs($object, $args);
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return mixed
     * @throws Exception
     */
    protected function callPrivateStatic($className, $methodName /*, $arg1, ... */)
    {
        if (!class_exists($className))
        {
            throw new Exception("Class {$className} does not exist");
        }

        if (!method_exists($className, $methodName))
        {
            throw new Exception($className." has no static method ".$methodName);
        }

        $args = array_slice(func_get_args(), 2);
        $method = new ReflectionMethod($className, $methodName);
        $method->setAccessible(TRUE);

        return $method->invokeArgs(NULL, $args);
    }

    public function testAddition()
    {
      $mathObject = new MathClass();
      $result = $this->callPrivate($mathObject,'addition', 1, 1);
      $this->assertEquals(2,$result);
    }

    public function testSubtraction()
    {
        $result = $this->callPrivateStatic('MathClass','subtraction', 1, 1);
        $this->assertEquals(0,$result);
    }
}