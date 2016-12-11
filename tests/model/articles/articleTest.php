<?php

require_once dirname(dirname(__DIR__)).'/testBase.php';

class articleTest extends testBase {

    public function setUp() {
        $this->className = 'articles\\article';
        parent::setUp();
    }

    public function testSave() {
        
        /* @var $object \fpcm\model\articles\article */
        $object = $this->object;

        $GLOBALS['article_title']   = 'FPCM UnitTest Article '.microtime(true);
        $GLOBALS['article_content'] =  'FPCM UnitTest Article from https://nobody-knows.org!';
        $GLOBALS['article_created'] = time();
        
        $object->setTitle($GLOBALS['article_title']);
        $object->setContent($GLOBALS['article_content']);
        $object->setCreatetime($GLOBALS['article_created']);
        $object->setCreateuser(1);
        $object->setPinned(1);
        $object->setComments(1);
        $object->setSources('https://nobody-knows.org');
        $object->setCategories(array(1));

        $result = $object->save();
        $this->assertGreaterThanOrEqual(1, $result);
        
        $GLOBALS['article_id'] = $result;
    }

    public function testUpdate() {
        
        /* @var $object \fpcm\model\articles\article */
        $object = $this->object;

        $object->setChangeuser(time());
        $object->setChangeuser(1);
        $object->setCategories(array(1));

        $result = $object->update();
        $this->assertTrue($result);
    }

    public function testGetArticle() {
        
        /* @var $object \fpcm\model\articles\article */
        $object = new fpcm\model\articles\article($GLOBALS['article_id']);

        $this->assertTrue($object->exists());
        $this->assertEquals($object->getTitle(), $GLOBALS['article_title']);
        $this->assertEquals($object->getContent(), $GLOBALS['article_content']);
        $this->assertEquals($object->getPinned(), 1);
        $this->assertEquals($object->getComments(), 1);
        $this->assertEquals($object->getCreateuser(), 1);
    }

    public function testGetMinMaxDate() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getMinMaxDate();
        $this->assertEquals($GLOBALS['article_created'], $result['maxDate']);
        $this->assertGreaterThanOrEqual(0, $result['minDate']);
    }

    public function testCountArticlesByCondition() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->countArticlesByCondition();
        $this->assertGreaterThanOrEqual(1, $result);
    }

    public function testGetArticlesByCondition() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesByCondition(array(
            'datefrom' => time() - 60,
            'dateto'   => time() + 60
        ));
        
        $this->assertTrue(is_array($result));
        $this->assertCount(1, $result);
        $this->assertArrayHasKey($GLOBALS['article_id'], $result);
        
        $obj = $result[$GLOBALS['article_id']];
        $this->assertTrue(is_a($obj, get_class($this->object)));
        $this->assertEquals($GLOBALS['article_title'], $obj->getTitle());
    }

    public function testGetArticlesAll() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesAll();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertArrayHasKey($GLOBALS['article_id'], $result);
        
        $obj = $result[$GLOBALS['article_id']];
        $this->assertTrue(is_a($obj, get_class($this->object)));
        $this->assertEquals($GLOBALS['article_title'], $obj->getTitle());
    }

    public function testGetArticlesActive() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesActive();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertArrayHasKey($GLOBALS['article_id'], $result);
        
        $obj = $result[$GLOBALS['article_id']];
        $this->assertTrue(is_a($obj, get_class($this->object)));
        $this->assertEquals($GLOBALS['article_title'], $obj->getTitle());
    }

    public function testGetArticlesArchived() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesArchived();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(0, $result);
        $this->assertArrayNotHasKey($GLOBALS['article_id'], $result);
    }

    public function testGetArticlesPostponed() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesPostponed();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(0, $result);
        $this->assertArrayNotHasKey($GLOBALS['article_id'], $result);
    }

    public function testGetArticlesDraft() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesDraft();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(0, $result);
        $this->assertArrayNotHasKey($GLOBALS['article_id'], $result);
    }

    public function testDelete() {
        
        
        /* @var $object \fpcm\model\articles\article */
        $object = new fpcm\model\articles\article($GLOBALS['article_id']);

        $result = $object->delete();
        $this->assertTrue($result);
        
        if ($object->exists()) {
            $this->assertEquals(1, $object->getDeleted());
        } else {
            $this->assertFalse($object->exists());
        }
        
    }

    public function testGetArticlesDeleted() {
        
        $list   = new fpcm\model\articles\articlelist();
        $result = $list->getArticlesDeleted();
        
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertArrayHasKey($GLOBALS['article_id'], $result);
        
        $obj = $result[$GLOBALS['article_id']];
        $this->assertTrue(is_a($obj, get_class($this->object)));
        $this->assertEquals($GLOBALS['article_title'], $obj->getTitle());
        $this->assertEquals(1, $obj->getDeleted());
    }

}
