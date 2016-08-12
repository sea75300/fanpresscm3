<?php
    /**
     * FanPress CM Support Module, https://nobody-knows.org
     *
     * nkorg/support event class: acpConfig
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\support\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $dbconf = \fpcm\classes\baseconfig::getDatabaseConfig();
            
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__), 'acp', 'main');
            $view->assign('dbconfig', $dbconf);
            $view->render();
        }

    }