<?php

namespace fpcm\modules\nkorg\sitemaplinklist\controller;
    
class checkpath extends \fpcm\controller\abstracts\ajaxController {

    protected $path;


    /**
     * Request-Handler
     * @return boolean
     */
    public function request() {
    
        if (!$this->session->exists()) {
            return false;
        }
        
        $this->path = $this->getRequestVar('path');
        
        return true;
    }

    public function process() {

        $sitemapxmlPath = dirname(\fpcm\classes\baseconfig::$baseDir).$this->path.'sitemap.xml';
        
        $this->returnCode = 0;
        $this->returnData['id']   = md5(uniqid(__METHOD__));
        $this->returnData['txt']  = $this->lang->translate('NKORG_SITEMAPLINKLIST_CHECKPATH_FAILED');
        $this->returnData['type'] = 'error';
        $this->returnData['icon'] = 'exclamation-triangle';

        if (!file_exists($sitemapxmlPath)) {
            $this->getResponse();
        }

        $this->config->setNewConfig(array(
            \fpcm\modules\nkorg\sitemaplinklist\nkorgsitemaplinklist::NKORG_SITEMAPLINKLIST_CONFIGKEY => $sitemapxmlPath
        ));
        $this->config->update();

        $this->returnCode = 1;
        $this->returnData['txt']  = $this->lang->translate('NKORG_SITEMAPLINKLIST_CHECKPATH_OK');
        $this->returnData['type'] = 'notice';
        $this->returnData['icon'] = 'check';
        
    }
}
?>