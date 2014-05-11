<?php

abstract class SeleniumParentTestCase extends PHPUnit_Extensions_Selenium2TestCase
{
    protected $screenShotsDir;

    public function setUp()
    {
        $this->setBrowser('chrome');
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowserUrl('http://localhost');

        if(defined('SCREENSHOT_DIR'))
        {
            $this->screenShotsDir = SCREENSHOT_DIR;
        }
        else
        {
            $this->screenShotsDir = __DIR__ . DIRECTORY_SEPARATOR . 'screenshots';
        }

        if(!file_exists($this->screenShotsDir))
        {
            mkdir($this->screenShotsDir);
        }
    }

    /**
     * Captures screenshot when tests fails
     * @param  Exception               $e
     * @throws PHPUnit_Framework_Error
     */
    public function onNotSuccessfulTest(Exception $e)
    {
        $fileName = $this->screenShotsDir . DIRECTORY_SEPARATOR . get_class($this) . '_' .  date('Y-m-d\TH-i-s') . '.png';
        file_put_contents($fileName,        $this->currentScreenshot());

        parent::onNotSuccessfulTest(
            new PHPUnit_Framework_Error('Url: '.$this->url() . '; Screenshot saved to: '.$fileName,
                $e->getCode(), $e->getFile(), $e->getLine(), $e)
        );
    }

    /**
     * checks page for PHP errors
     */
    protected function checkPage()
    {
        $pageSource = $this->source();

        if(strpos($pageSource,'Fatal error:') !== false)
        {
            $this->fail('Fatal error');
        }

        if(strpos($pageSource,'Warning:') !== false)
        {
            $this->fail('Warning:');
        }

        if(strpos($pageSource,'Parse error:') !== false)
        {
            $this->fail('Parse error:');
        }
    }
}
