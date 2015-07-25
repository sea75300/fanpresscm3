<?php
    /**
     * Sitemap Link List, http://nobody-knows.org/fanpress3/
     *
     * nkorg/sitemaplinklist event class: acpConfig
     * 
     * @version 3.0.0
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\sitemaplinklist\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__), 'acp', 'main');
            
            $cfgKey = \fpcm\modules\nkorg\sitemaplinklist\nkorgsitemaplinklist::NKORG_SITEMAPLINKLIST_CONFIGKEY;
            
            if ($this->config->$cfgKey) {
                $savedpath = $this->config->$cfgKey;   
                
                $listcontent = array();
                
                $xmlObject = new \SimpleXMLElement(file_get_contents($savedpath));
                foreach($xmlObject->children() as $child) {
                    $listcontent[base64_encode($child->loc->__toString())] = $child->loc->__toString();
                };                 
                
            } else {
                $savedpath   = '/';
                $listcontent = false;
            }
            
            $acfile      = new \fpcm\modules\nkorg\sitemaplinklist\model\activelinkfile();
            $activeLinks = array_map('base64_encode', $acfile->loadData());
            
            $view->assign('savedpath', $savedpath);
            $view->assign('listcontent', $listcontent);
            $view->assign('activeLinks', $activeLinks);
            $view->render();
        }

    }