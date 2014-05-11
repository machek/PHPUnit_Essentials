<?php

class SeleniumFirstTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->setBrowser('firefox');
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowserUrl('https://www.google.com/');
    }

    /**
     * Method testSeleniumFirst
     * @test
     */
    public function testSeleniumFirst()
    {
        $this->timeouts()->implicitWait(10000);
        $this->url("/");
        $this->byId("gbqfq")->value("phpunit");
        $this->byLinkText("Documentation")->click();
        $this->byLinkText("Multiple HTML files")->click();
        $this->byLinkText("13. PHPUnit and Selenium")->click();
        $result = $this->byCssSelector("h1.title")->text();
        $this->assertEquals("Chapter 13. PHPUnit and Selenium", $result);
    }
}
