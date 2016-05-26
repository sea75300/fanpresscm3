<?php

namespace fpcm\modules\nkorg\rssimport\controller;
    
class runimport extends \fpcm\controller\abstracts\ajaxController {

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

        $failed = array('code' => 0, 'msg' => 'NKORG_RSSIMPORT_IMPORTFAILED');
        $success = array('code' => 1, 'msg' => 'NKORG_RSSIMPORT_IMPORTSUCCESS');

        try {
            $xmlObj = simplexml_load_file($this->feedPath);
        } catch (Exception $e) {
            $this->response($failed);
        }

        if (!is_a($xmlObj, 'SimpleXMLElement')) {
            $this->response($failed);
        }

        $rss20 = new \fpcm\modules\nkorg\rssimport\model\rss20($xmlObj);
        if ($rss20->check() && $rss20->import()) {
            $this->response($success);
        }

    }

    private function response($msgArray) {
        die(json_encode($msgArray));  
    }

}
?>