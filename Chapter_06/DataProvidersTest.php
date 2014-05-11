<?php

class DataProvidersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function providerArray()
    {
        $inputOne = array(1,2,3,4,5);
        $inputTwo = array(10,20,30,40,50);
        $inputThree = array(100,200,300,400,500);

        return array(
            array('inputArray' => $inputOne),
            array('inputArray' => $inputTwo),
            array('inputArray' => $inputThree),
        );

    }

    /**
     * @param  array $inputArray
     * @dataProvider providerArray
     */
    public function testPop(array $inputArray)
    {
        $expectedResult = count($inputArray)-1;
        array_pop($inputArray);
        $this->assertEquals($expectedResult,count($inputArray));

    }

    /**
     * @param  array $inputArray
     * @dataProvider providerArray
     */
    public function testSum(array $inputArray)
    {
        $expectedResult = 0;

        for ($i = 0; $i < count($inputArray); $i++) {
            $expectedResult += $inputArray[$i];
        }

        $this->assertEquals($expectedResult,array_sum($inputArray));
    }
}
