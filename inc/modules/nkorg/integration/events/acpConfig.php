<?php
    /**
     * FanPress CM Integration, https://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: acpConfig
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\integration\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $moduleKey = \fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__);            
            
            $view = new \fpcm\model\view\module($moduleKey, 'acp', 'main', '');
            
            $chapters = array();
            if ($this->config->system_mode) {
                $chapters['NKORG_INTEGRATION_PHPINCLUDE']       = 'phpinclude';
            }
            
            $chapters['NKORG_INTEGRATION_CSSCLASSES']           = 'cssclasses';
            $chapters['NKORG_INTEGRATION_SHOWARTICLES' ]        = 'showarticles';
            $chapters['NKORG_INTEGRATION_SHOWLATEST']           = 'showlatest';
            
            if ($this->config->system_mode) {
                $chapters['NKORG_INTEGRATION_SHOWPAGETITEL']    = 'showpagetitle';
                $chapters['NKORG_INTEGRATION_SHOWARTICLETITLE'] = 'showarticletitle';
                $chapters['NKORG_INTEGRATION_UTF8OUTPUT']       = 'utf8output';
            }
            
            $chapters['NKORG_INTEGRATION_RSSFEED'] = 'rssfeed';
            
            $view->assign('chapters', $chapters);
            $view->assign('sysmode', $this->config->system_mode);
            $view->assign('sysurl', $this->config->system_url);
            $view->render();
            
            
        }

    }