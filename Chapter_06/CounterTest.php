<?php
class CounterTest extends PHPUnit_Framework_TestCase
{
    private static $countFrom = 1;
    private $result = 0;

    public static function setUpBeforeClass()
    {
        self::$countFrom = 2;
    }

    public function setUp()
    {
        $this->result = self::$countFrom;
   }

    public function testAdd()
    {
        $this->result += 1;
        $this->assertEquals(3, $this->result);
    }

    public function testTakeAway()
    {
        $this->result -= 1;
        $this->assertEquals(1, $this->result);
    }
}
