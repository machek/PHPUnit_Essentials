<?php

require_once 'SumFinder.php';

class SumFinderTest  extends PHPUnit_Framework_TestCase
{
    public function testSumFinder()
    {
        $input = array(0, 1, 2, 3, 6, 7, 8, 9, 11, 12, 14);
        $result = array('group'=>'6, 7, 8, 9', 'sum'=> 30);
        $this->assertEquals($result, sumFinder($input));
    }

    public function testCompareArrays()
    {
        $array1 = array(0,1,2,3);
        $array2 = array(6,7,8,9);

        // $array2 > $array1
        $this->assertEquals(-1,compareArrays($array1,$array2));
        // $array1 < $array2
        $this->assertEquals(1,compareArrays($array2,$array1));
        // $array2 = $array2
        $this->assertEquals(0,compareArrays($array2,$array2));
    }
}