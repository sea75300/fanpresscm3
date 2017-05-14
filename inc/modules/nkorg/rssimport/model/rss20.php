<?php

namespace fpcm\modules\nkorg\rssimport\model;

class rss20 extends feed {

    /**
     *
     * @var string
     */
    protected $baseXPath = 'channel/item';

    public function getList() {
        
        $items = $this->getItems();
        
        $data = array();
        foreach ($items as $item) {
            $data[] = array(
                'title' => (string) $item->title,
                'id'    => md5($item->guid),
                'link'  => (string) $item->link
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

}
