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
        
        if (file_exists($sitemapxmlPath)) {
            
            $this->config->setNewConfig(array(
                \fpcm\modules\nkorg\sitemaplinklist\nkorgsitemaplinklist::NKORG_SITEMAPLINKLIST_CONFIGKEY => $sitemapxmlPath
            ));
            $this->config->update();
            
            die(1);
        }
        
        die(0);
    }
}
?>