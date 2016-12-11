<?php

require_once dirname(dirname(__DIR__)).'/testBase.php';

class yatdlTest extends testBase {

    public function setUp() {
        $this->object = new fpcm\model\system\yatdl(__DIR__.'/test.yml');
    }
    
    public function testGetArray() {

        $data = $this->object->getArray();
        $this->assertTrue(is_array($data));

        $this->assertEquals('sample', $data['name']);
        $this->assertEquals('id', array_shift(array_keys($data['cols'])));
        $this->assertEquals('id', $data['primarykey']);
        $this->assertEquals('utf8', $data['charset']);
        $this->assertEquals('InnoDB', $data['engine']);
        $this->assertEquals('id', $data['autoincrement']['colname']);
        $this->assertEquals(1, $data['autoincrement']['start']);
        $this->assertFalse(is_array($data['indices']));

    }
    
    public function testParse() {

        $haystack = [
            fpcm\model\system\yatdl::ERROR_YAMLCHECK_FAILED,
            fpcm\model\system\yatdl::ERROR_YAMLPARSER_COLS,
            fpcm\model\system\yatdl::ERROR_YAMLPARSER_AUTOINCREMENT,
            fpcm\model\system\yatdl::ERROR_YAMLPARSER_INDICES,
            0
        ];
        
        $result = (int) $this->object->parse();
        $this->assertFalse(in_array($result, $haystack));

    }
    
    public function testGetSqlString() {

        $this->object->parse();
        $data = $this->object->getSqlString();

        $this->assertContains('CREATE TABLE {{dbpref}}_sample', $data, 'Missing create table data', true);
        $this->assertContains('id', $data, 'Missing "id" col', true);
        $this->assertContains('config_name', $data, 'Missing "config_name" col', true);
        $this->assertContains('config_value', $data, 'Missing "config_value" col', true);

    }

}