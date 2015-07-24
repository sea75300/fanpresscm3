<?php

namespace fpcm\modules\nkorg\tweetextender\model;

class term extends \fpcm\model\abstracts\model {
    
    protected $searchterm = '';
    
    protected $replaceterm = '';
    
    public function __construct($id = null) {
        $this->table        = \fpcm\modules\nkorg\tweetextender\nkorgtweetextender::NKORGTWEETEXTENDER_TABLE_NAME;
        $this->editAction   = 'nkorg/tweetextender/editterm&id=';
        
        return parent::__construct($id);
    }
    
    public function getSearchterm() {
        return $this->searchterm;
    }

    public function getReplaceterm() {
        return $this->replaceterm;
    }

    public function setSearchterm($searchterm) {
        $this->searchterm = $searchterm;
    }

    public function setReplaceterm($replaceterm) {
        $this->replaceterm = $replaceterm;
    }

    public function save() {
        $params = $this->getPreparedSaveParams();        
        return $this->dbcon->insert($this->table, implode(',', array_keys($params)), implode(', ', $this->getPreparedValueParams(count($params))), array_values($params));
    }

    public function update() {
        $params     = $this->getPreparedSaveParams();
        $fields     = array_keys($params);
        $params[]   = $this->getId();
        
        return $this->dbcon->update($this->table, $fields, array_values($params), 'id = ?');
    }

}
