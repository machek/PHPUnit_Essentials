<?php

class FirstTest extends PHPUnit_Framework_TestCase {

    public function testAddition(){
        $this->assertEquals(2, 1 + 1);
    }

    public function testSubtraction(){
         $this->assertEquals(0.17, 1 - 0.83);
    }

    public function testMultiplication(){
        $this->assertEquals(10, 2 * 5);
    }

    public function testDivision(){
        $this->assertTrue(2 == (10 / 5));
    }
}