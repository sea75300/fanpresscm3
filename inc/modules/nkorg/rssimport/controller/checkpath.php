<?php

namespace fpcm\modules\nkorg\rssimport\controller;
    
class checkpath extends \fpcm\controller\abstracts\ajaxController {

    private $feedPath = '';

    /**
     * Request-Handler
     * @return boolean
     */
    public function request() {
    
        if (!$this->session->exists()) {
            return false;
        }
        
        $this->feedPath = $this->getRequestVar('feedPath');
        
        return true;
    }

    public function process() {

        $failed = array('code' => 0, 'msg' => 'nkorg_rssimport_checkfailed');
        $sucess = array('code' => 1, 'msg' => 'nkorg_rssimport_checkok');
        
        try {
            $xml = simplexml_load_file($this->feedPath);
        } catch (Exception $e) {
            $this->response($failed);
        }

        if (!is_a($xml, 'SimpleXMLElement')) {
            $this->response($failed);
        }
        
        $this->response($sucess);
    }

    private function response($msgArray) {
        die(json_encode($msgArray));  
    }

}
?>