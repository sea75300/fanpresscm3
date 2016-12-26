<?php

require_once dirname(dirname(dirname(__DIR__))).'/fpcmapi.php';

class fpcmAPiTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @var \fpcmAPI
     */
    protected $object;

    /**
     * @var bool
     */
    protected $backupGlobals = false;

    public function setUp() {
        
        $this->object = new fpcmAPI();
        
        parent::setUp();
    }
    
    public function testLoginExternal() {
        
        $result = $this->object->loginExternal([
            'username' => 'stefan',
            'password' => 'Stefan1'
        ]);
        
        $this->assertFalse(is_bool($result));
        $this->assertTrue(is_string($result));
        $this->assertNotEmpty($result);
        
        $GLOBALS['testSessionId'] = $result;
        
    }
    
    public function testLoginExternalPing() {
        
        $result = $this->object->loginExternal(['sessionId' => $GLOBALS['testSessionId']]);
        $this->assertTrue($result);
        
    }
    
    public function testLogoutExternalPing() {
        
        $result = $this->object->logoutExternal($GLOBALS['testSessionId']);
        $this->assertTrue($result);
        
        $result2 = $this->object->loginExternal(['sessionId' => $GLOBALS['testSessionId']]);
        $this->assertFalse($result2);
        
    }
    
}