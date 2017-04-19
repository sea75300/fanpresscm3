<?php

require_once dirname(dirname(__DIR__)).'/testBase.php';

class userListTest extends testBase {
    
    /**
     * @var \fpcm\model\users\userList
     */
    protected $object;

    public function setUp() {
        $this->className = 'users\\userList';
        parent::setUp();
    }

    public function testGetUserIdByUsername() {
        
        $this->createUser();

        $id = $this->object->getUserIdByUsername($GLOBALS['userName']);
        $this->assertGreaterThanOrEqual(1, $id);
    }
    
    public function testGetUsersAll() {
        $data = $this->object->getUsersAll();
        $this->assertTrue(isset($data[$GLOBALS['objectId']]));
    }
    
    public function testGetUsersActive() {
        $data = $this->object->getUsersActive();
        $this->assertTrue(isset($data[$GLOBALS['objectId']]));
    }
    
    public function testDiableUsers() {
        $result = $this->object->diableUsers([$GLOBALS['objectId']]);
        $this->assertTrue($result);
    }
    
    public function testGetUsersDisabled() {
        $data = $this->object->getUsersDisabled();
        $this->assertTrue(isset($data[$GLOBALS['objectId']]));
    }
    
    public function testEnableUsers() {
        $result = $this->object->enableUsers([$GLOBALS['objectId']]);
        $this->assertTrue($result);
    }
    
    public function testGetUsersByIds() {
        $data = $this->object->getUsersByIds([$GLOBALS['objectId']]);
        $this->assertTrue(isset($data[$GLOBALS['objectId']]));
    }
    
    public function testGetEmailByUserId() {
        $data = $this->object->getEmailByUserId($GLOBALS['objectId']);
        $this->assertEquals($GLOBALS['userEmail'], $data);
    }
    
    public function testGetUsersEmailList() {
        $data = $this->object->getUsersEmailList();
        $this->assertTrue(isset($data[$GLOBALS['userEmail']]));
        $this->assertTrue(in_array($GLOBALS['objectId'], $data));
    }
    
    public function testGetUsersNameList() {
        $data = $this->object->getUsersNameList();
        $this->assertTrue(isset($data[$GLOBALS['userName']]));
        $this->assertTrue(in_array($GLOBALS['objectId'], $data));
    }
    
    public function testCountActiveUsers() {
        $data = $this->object->countActiveUsers();
        $this->assertGreaterThanOrEqual(1, $data);
    }


    public function testDeleteItems() {

        $result = $this->object->deleteUsers([$GLOBALS['objectId']]);
        $this->assertTrue($result);
        
        $data = $this->object->getUsersAll();
        $this->assertFalse(isset($data[$GLOBALS['objectId']]));
    }
    
    private function createUser() {

        $GLOBALS['userName']  = 'fpcmTestUser'.microtime(true);
        $GLOBALS['userEmail'] = 'test@nobody-knows.org';

        /* @var $object fpcm\model\users\author */
        $object = new fpcm\model\users\author();
        $object->setDisplayName($GLOBALS['userName']);
        $object->setUserName($GLOBALS['userName']);
        $object->setEmail($GLOBALS['userEmail']);
        $object->setPassword('fpcmTest2017');
        $object->setRegistertime(time());
        $object->setRoll(3);
        $object->setDisabled(0);

        $result = $object->save();
        $this->assertTrue($result);
        
        $GLOBALS['objectId'] = $object->getId();
    }

}