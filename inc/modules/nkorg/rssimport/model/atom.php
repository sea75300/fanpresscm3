<?php

namespace fpcm\modules\nkorg\rssimport\model;

class atom extends feed {

    /**
     *
     * @var string
     */
    protected $baseXPath = '//atom:entry';

    public function __construct(\SimpleXMLElement $xmlObj, array $feedIds = array(), $userId = 0, array $categories = array()) {
        parent::__construct($xmlObj, $feedIds, $userId, $categories);
        $this->xmlObj->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
    }
    
    public function getList() {
        
        $items = $this->getItems();

        $data = array();
        foreach ($items as $item) {
            $data[] = array(
                'title' => (string) $item->title,
                'id'    => md5($item->guid),
                'link'  => (string) $item->link->attributes()->href
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
            $article->setContent((string) $item->content);
            $article->setCreatetime(strtotime((string) $item->published));
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

}
