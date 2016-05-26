<?php

namespace fpcm\modules\nkorg\rssimport\model;

class rss20 extends \fpcm\model\abstracts\staticModel {
    
    /**
     *
     * @var \SimpleXMLElement
     */
    private $xmlObj;

    public function __construct(\SimpleXMLElement $xmlObj) {
        $this->xmlObj = $xmlObj;
    }
    
    public function check() {
        $success = $this->xmlObj->xpath('channel/item');
        
        return is_array($success) ? true : false;
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

            \fpcm\classes\logs::syslogWrite(array(
                utf8_encode((string) $item->title),
                (string) $item->pubDate,
                (string) $item->category,
                (string) $item->description,
                (string) $item->creator,
                (string) $item->author
            ));

        }
        
        return true;
    }
    
    private function getItems() {

        return $this->xmlObj->xpath('channel/item');;

    }
    


}
