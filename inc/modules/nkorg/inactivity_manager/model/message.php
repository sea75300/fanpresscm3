<?php

namespace fpcm\modules\nkorg\inactivity_manager\model;

class message extends \fpcm\model\abstracts\model {
    
    protected $text      = '';
    
    protected $starttime = 0;
    
    protected $stoptime  = 0;

    public function __construct($id = null) {
        $this->table        = \fpcm\modules\nkorg\inactivity_manager\nkorginactivity_manager::NKORGINACTIVITY_MANAGER_TABLE_NAME;
        $this->editAction   = 'nkorg/inactivity_manager/editmessage&id=';
        
        return parent::__construct($id);
    }
    
    public function getText() {
        return $this->text;
    }

    public function getStarttime() {
        return (int) $this->starttime;
    }

    public function getStoptime() {
        return (int) $this->stoptime;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setStarttime($starttime) {
        $this->starttime = (int) $starttime;
    }

    public function setStoptime($stoptime) {
        $this->stoptime = (int) $stoptime;
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
    
    public function __toString() {
        
        $html   = array();
        $html[] = '<div class="nkorg-inactivity-manager-box">';
        $html[] = ' <div class="nkorg-inactivity-manager-box-inner">';
        $html[] = '     <span class="nkorg-inactivity-manager-date">'.date('d.m.Y', $this->getStarttime()).' - '.date('d.m.Y', $this->getStoptime()).'</span>';
        $html[] = '     <span class="nkorg-inactivity-manager-text">'.$this->getText().'</span>';
        $html[] = ' </div>';
        $html[] = '</div>';
        
        return implode(PHP_EOL, $html);
    }

}
