<?php

namespace fpcm\modules\nkorg\sitemaplinklist\controller;
    
class savelinks extends \fpcm\controller\abstracts\ajaxController {

    protected $data;


    /**
     * Request-Handler
     * @return boolean
     */
    public function request() {
    
        if (!$this->session->exists()) {
            return false;
        }
        
        $this->data = $this->getRequestVar('selectedLinks', array(1,4,7));
        
        return true;
    }

    public function process() {

        $this->data = json_decode($this->data, true);
        $this->data = array_map('base64_decode', $this->data);
        
        $alfile = new \fpcm\modules\nkorg\sitemaplinklist\model\activelinkfile();
        $res = $alfile->save($this->data);
        
        die($res);
        
    }
}
?>