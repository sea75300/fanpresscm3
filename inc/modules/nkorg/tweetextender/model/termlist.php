<?php

namespace fpcm\modules\nkorg\tweetextender\model;

class termlist extends \fpcm\model\abstracts\model {

    public function __construct($id = null) {
        $this->table = \fpcm\modules\nkorg\tweetextender\nkorgtweetextender::NKORGTWEETEXTENDER_TABLE_NAME;
        return parent::__construct($id);
    }
    
    public function getTerms() {
        
        $termRows = $this->dbcon->fetch($this->dbcon->select($this->table), true);
        
        $terms = array();
        foreach ($termRows as $termRow) {
            $term = new term();
            $term->createFromDbObject($termRow);            
            $terms[] = $term;
        }
        
        return $terms;
    }
    
    public function deleteTerms(array $ids) {
        
        if (!count($ids)) {
            return false;
        }
        
        $ids = array_map('intval', $ids);
        return $this->dbcon->delete($this->table, 'id IN ('.implode(',', $ids).')');
    }

    public function save() {
        return false;
    }

    public function update() {
        return false;
    }


}
