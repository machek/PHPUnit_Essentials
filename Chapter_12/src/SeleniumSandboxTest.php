<?php

class SeleniumSandboxTest extends SeleniumParentTestCase
{
     /**
     * @dataProvider dataProvider
     * @param $testedValue
     * @param $expectedResult
     */
    public function testSeleniumSandbox($testedValue, $expectedResult)
    {
        $this->url("http://localhost/sandbox.php");
        $this->checkPage();
        $this->assertEquals("Selenium Sandbox", $this->byCssSelector("h1.page-header")->text());

        $this->byId("number_a")->value($testedValue[0]);
        $this->byId("number_b")->value($testedValue[1]);

        $criterion = new PHPUnit_Extensions_Selenium2TestCase_ElementCriteria("xpath");
        $criterion->value("//input[@type='checkbox']");

        $checkboxes = $this->elements($criterion);

        for($i=0;$i<count($checkboxes);$i++)
        {
            $checkboxes[$i]->click();
            $this->assertTrue($checkboxes[$i]->selected());
        }

        $this->byCssSelector("input.btn")->click();
        $this->checkPage();

        $this->assertEquals($expectedResult[0], $this->byId("result_addition")->text());
        $this->assertEquals($expectedResult[1], $this->byId("result_substitution")->text());
        $this->assertEquals($expectedResult[2], $this->byId("result_multiplication")->text());
        $this->assertEquals($expectedResult[3], $this->byId("result_division")->text());
    }

    public function dataProvider()
    {
        return array(
            array('input' => array(1,0), 'result' => array(2,0,1,1)),
            array('input' => array(20,10), 'result' => array(30,10,200,2)),
            array('input' => array(1000,100), 'result' => array(1100,900,100000,10)),
        );
    }
}
