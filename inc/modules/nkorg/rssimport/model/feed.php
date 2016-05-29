<?php

namespace fpcm\modules\nkorg\rssimport\model;

abstract class feed extends \fpcm\model\abstracts\staticModel {
    
    /**
     *
     * @var string
     */
    protected $baseXPath = '';
    
    /**
     *
     * @var \SimpleXMLElement
     */
    protected $xmlObj;
    
    /**
     *
     * @var array
     */
    protected $feedIds = array();
    
    /**
     *
     * @var int
     */
    protected $userId = 0;
    
    /**
     *
     * @var array
     */
    protected $categories = array();

    function __construct(\SimpleXMLElement $xmlObj, array $feedIds = array(), $userId = 0, array $categories = array()) {

        parent::__construct();
        
        $this->xmlObj     = $xmlObj;
        $this->feedIds    = $feedIds;
        $this->userId     = $userId;
        $this->categories = $categories;
    }

    public function check() {
        $success = $this->getItems();
        return is_array($success) && count($success) ? true : false;
    }
    
    protected function getItems() {

        return $this->xmlObj->xpath($this->baseXPath);

    }
    
    abstract public function getList();

    abstract public function import();

}
