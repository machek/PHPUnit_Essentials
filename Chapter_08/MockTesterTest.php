<?php

class MockTesterTest extends PHPUnit_Framework_TestCase
{
    public function testOne()
    {
        $mockTester = $this->getMock('MockTester');
        $this->assertEquals(1, $mockTester->getOne());
        $this->assertEquals(2, $mockTester->getTwo());
    }

    public function testTwo()
    {
        $mockTester = $this->getMock('MockTester',
            array('getTwo'));
        $this->assertEquals(1, $mockTester->getOne());
        $this->assertEquals(2, $mockTester->getTwo());
    }

    public function testThree()
    {
        $mockTester = $this->getMock('MockTester',
            array('getOne'));

        $mockTester->expects($this->any())
            ->method('getOne')
            ->will($this->returnValue(3));

        $this->assertEquals(3, $mockTester->getOne());
        $this->assertEquals(2, $mockTester->getTwo());
    }
}