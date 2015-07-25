<?php

namespace fpcm\modules\nkorg\sitemaplinklist\model;

class activelinkfile extends \fpcm\model\abstracts\staticModel {

    protected $filename;

    public function __construct() {
        $this->filename = \fpcm\classes\baseconfig::$configDir.'sitemaplinklist.dat';
    }

    public function save(array $data) {        
        return file_put_contents($this->filename, json_encode($data));        
    }

    public function loadData() {

        if (!file_exists($this->filename)) {
            return array();
        }
        
        return json_decode(file_get_contents($this->filename), true);
    }
}
