<?php

use Nearsoft\SeleniumClient\By;
use Nearsoft\SeleniumClient\WebDriver;
use Nearsoft\SeleniumClient\WebDriverWait;
use Nearsoft\SeleniumClient\DesiredCapabilities;

class SeleniumClientTest extends PHPUnit_Framework_TestCase
{
    /** @var WebDriver */
    private $_driver = null;

    public function setUp()
    {
        $desiredCapabilities = new DesiredCapabilities("chrome");

        $this->_driver = new WebDriver($desiredCapabilities);
        $this->_driver->setScreenShotsDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'screenshots');
    }

    public function tearDown()
    {
        if ($this->_driver != null) { $this->_driver->quit(); }
    }

    public function testSeleniumFirst()
    {
        $this->_driver->get("https://www.google.com");
        $this->_driver->findElement(By::id("gbqfq"))->setValue("phpunit");
        $this->_driver->findElement(By::id("gbqfba"))->click();

        $wait = new WebDriverWait(10);
        $documentationLink = $wait->until($this->_driver,"findElement",array(By::linkText("Documentation"),true));
        $documentationLink->click();

        $this->_driver->findElement(By::linkText("Multiple HTML files"))->click();
        $this->_driver->findElement(By::linkText("13. PHPUnit and Selenium"))->click();
        $result = $this->_driver->findElement(By::cssSelector("h1.title"))->getText();
        $this->assertEquals("Chapter 13. PHPUnit and Selenium", $result);
        $this->_driver->screenshot();
    }
}
