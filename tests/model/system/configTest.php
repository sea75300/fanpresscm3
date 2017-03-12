<?php

require_once dirname(dirname(__DIR__)).'/testBase.php';

class configTest extends testBase {
    
    /**
     * @var fpcm\model\system\config
     */
    protected $object;
    
    /**
     * @var fpcm\classes\cache
     */
    protected $cache;

    public function setUp() {
        $this->object = new fpcm\model\system\config(false, false);
    }
    
    public function testAddKey() {
        $GLOBALS['newKey']   = 'config_option_unittest';
        $GLOBALS['newValue'] = '1234567890';

        $result = $this->object->add($GLOBALS['newKey'], $GLOBALS['newValue']);
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertEquals($GLOBALS['newValue'], $this->object->{$GLOBALS['newKey']});
        
    }
    
    public function testUpdateKey() {
        $GLOBALS['newValue'] = '9876543210';

        $this->object->setNewConfig([
            $GLOBALS['newKey'] => $GLOBALS['newValue']
        ]);

        $this->assertTrue($this->object->update());
        $this->assertEquals($GLOBALS['newValue'], $this->object->{$GLOBALS['newKey']});

    }
    
    public function testSetMaintenanceMode() {

        $this->assertTrue($this->object->setMaintenanceMode(1));
        $this->assertEquals(1, $this->object->system_maintenance);

        $this->assertTrue($this->object->setMaintenanceMode(0));
        $this->assertEquals(0, $this->object->system_maintenance);

    }
    
    public function testRemoveKey() {
        $this->assertTrue($this->object->remove($GLOBALS['newKey']));
        $this->object->init();

        $this->object = new fpcm\model\system\config(false, false);
        $this->assertFalse($this->object->{$GLOBALS['newKey']});

    }

}