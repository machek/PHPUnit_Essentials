<?php

use org\bovigo\vfs\vfsStream;

class UtilCsvTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var org\bovigo\vfs\vfsStreamDirectory
     */
    private $vfsDir;

    /**
     * @var string system temp directory
     */
    private $dir;

    public function setUp()
    {
        $this->vfsDir = vfsStream::setup('dataDir');
        $this->dir = sys_get_temp_dir();
    }

    public function tearDown()
    {
        if(file_exists($this->dir . DIRECTORY_SEPARATOR . 'export.csv'))
        {
            unlink($this->dir . DIRECTORY_SEPARATOR . 'export.csv');
        }
    }

    public function testCreateCsv()
    {
        $data = array(
            array('Column 1','Column 2','Column 3'),
            array(1,2,3),
            array(5,6,7)
        );

        $this->assertTrue(UtilCsv::createCsv($data,$this->dir,'export.csv'));
        $this->assertFileExists($this->dir .DIRECTORY_SEPARATOR . 'export.csv');
    }

    public function testCreateCsvVfs()
    {
        $data = array(
            array('Column 1','Column 2','Column 3'),
            array(1,2,3),
            array(5,6,7)
        );

        $this->assertTrue(UtilCsv::createCsv($data,vfsStream::url('dataDir'),'export.csv'));
        $this->assertFileExists($this->vfsDir->getChild('export.csv')->url());
    }
}
