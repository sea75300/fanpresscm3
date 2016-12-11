<?php

require_once dirname(dirname(__DIR__)).'/testBase.php';

class articlesTest extends testBase {

    public function setUp() {
        $this->className = 'articles\\articlelist';
        parent::setUp();
    }

    public function testGetArticlesAll() {
        
        $data = $this->object->getArticlesAll();
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, count($data));
        
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);

    }

    public function testGetArticlesActive() {
        
        $data = $this->object->getArticlesActive();
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, count($data));

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);
        $this->assertEquals(0, $object->getDraft());
        $this->assertEquals(0, $object->getArchived());
        $this->assertEquals(0, $object->getDeleted());

    }

    public function testGetArticlesArchived() {
        
        $data = $this->object->getArticlesArchived();
        
        $count = count($data);        
        if ($count == 0) {
            $this->markTestSkipped('No articles available in db');
        }
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, $count);

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);
        $this->assertEquals(1, $object->getArchived());
        $this->assertEquals(0, $object->getDeleted());

    }

    public function testGetArticlesPostponed() {
        
        $data = $this->object->getArticlesPostponed();
        
        $count = count($data);        
        if ($count == 0) {
            $this->markTestSkipped('No articles available in db');
        }
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, $count);

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);
        $this->assertEquals(1, $object->getPostponed());
        $this->assertEquals(0, $object->getDeleted());
        $this->assertEquals(0, $object->getDraft());
        $this->assertEquals(0, $object->getApproval());

    }

    public function testGetArticlesDeleted() {
        
        $data = $this->object->getArticlesDeleted();
        
        $count = count($data);        
        if ($count == 0) {
            $this->markTestSkipped('No articles available in db');
        }
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, $count);

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);
        $this->assertEquals(1, $object->getDeleted());

    }

    public function testGetArticlesDraft() {
        
        $data = $this->object->getArticlesDraft();
        
        $count = count($data);        
        if ($count == 0) {
            $this->markTestSkipped('No articles available in db');
        }
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, $count);

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);
        $this->assertEquals(0, $object->getDeleted());
        $this->assertEquals(1, $object->getDraft());

    }

    public function testArticlesByCondition() {
        
        $cond = [
            'user'    => 1,
            'deleted' => 0,
            'limit'   => [1,0]
        ];
        
        $data = $this->object->getArticlesByCondition($cond);
        
        $count = count($data);        
        if ($count == 0) {
            $this->markTestSkipped('No articles available in db');
        }
        
        $this->assertTrue(is_array($data));
        $this->assertGreaterThanOrEqual(1, $count);

        /* @var $object \fpcm\model\articles\article */
        $object = array_shift($data);
        $this->assertInstanceOf('\\fpcm\\model\\articles\\article', $object);

    }


}