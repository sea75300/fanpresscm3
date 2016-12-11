<?php

require_once dirname(__DIR__).'/inc/common.php';

class testBase extends \PHPUnit_Framework_TestCase {

    /**
     * @var string
     */
    protected $className;   
    
    /**
     * @var \fpcm\model\abstracts\model
     */
    protected $object;

    /**
     * @var bool
     */
    protected $backupGlobals = false;

    public function setUp() {        
        $class = '\\fpcm\\model\\'.$this->className;
        $this->object = new $class();
        $this->name   = __CLASS__;
    }

    public function tearDown() {
        
    }

}
