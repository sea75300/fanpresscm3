<?php

namespace fpcm\modules\nkorg\rssimport\model;

class rss20 extends \fpcm\model\abstracts\staticModel {
    
    /**
     *
     * @var \SimpleXMLElement
     */
    private $xmlObj;
    
    /**
     *
     * @var array
     */
    private $feedIds = array();
    
    /**
     *
     * @var int
     */
    private $userId = 0;
    
    /**
     *
     * @var array
     */
    private $categories = array();

    function __construct(\SimpleXMLElement $xmlObj, array $feedIds = array(), $userId = 0, array $categories = array()) {

        parent::__construct();
        
        $this->xmlObj     = $xmlObj;
        $this->feedIds    = $feedIds;
        $this->userId     = $userId;
        $this->categories = $categories;
    }

    public function check() {
        $success = $this->xmlObj->xpath('channel/item');
        return is_array($success) && count($success) ? true : false;
    }
    
    public function getList() {
        
        $items = $this->getItems();
        
        $data = array();
        foreach ($items as $item) {
            $data[] = array(
                'title' => (string) $item->title,
                'id'    => md5($item->guid)
            );
        }
        
        return $data;
        
    }

    public function import() {

        $items = $this->getItems();

        foreach ($items as $item) {
            
            if (!in_array(md5($item->guid), $this->feedIds)) {
                continue;
            }
            
            $article = new \fpcm\model\articles\article();
            $article->setTitle((string) $item->title);
            $article->setContent((string) $item->description);
            $article->setCreatetime(strtotime((string) $item->pubDate));
            $article->setChangetime(time());
            $article->setChangeuser($this->session->getUserId());
            $article->setCreateuser($this->userId);
            $article->setCategories($this->categories);
            $res = $article->save();
            
            if ($res === false) {
                trigger_error("Error while import of article with title '{$article->getTitle()}'. Cancel import process.");
                return false;
            }

        }
        
        return true;
    }
    
    private function getItems() {

        return $this->xmlObj->xpath('channel/item');;

    }
    


}
