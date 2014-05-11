<?php

class DependsTest extends PHPUnit_Framework_TestCase
{
    public function testArrayFill()
    {
        $testedArray = array_fill(0,11,1);
        $this->assertInternalType('array', $testedArray);

        return $testedArray;
    }

    /**
     * @param  array $inputArray
     * @return array
     * @depends testArrayFill
     */
    public function testPop(array $inputArray)
    {
        array_pop($inputArray);
        $this->assertEquals(10,count($inputArray));

        return $inputArray;
    }

    /**
     * @param  array $inputArray
     * @return array
     * @depends testPop
     */
    public function testSum(array $inputArray)
    {
        $this->assertEquals(10,array_sum($inputArray));
    }
}
