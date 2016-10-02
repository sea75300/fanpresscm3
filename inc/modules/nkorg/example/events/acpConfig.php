<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: acpConfig
     * 
     * @version 3.4.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
           
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__), 'acp', 'main');

            $view->addMessage('FPCM_EXAMPLE_HEADLINE');
            $view->addNoticeMessage('FPCM_EXAMPLE_HEADLINE');
            $view->addErrorMessage('FPCM_EXAMPLE_HEADLINE');

            $view->assign('logfiledata', \fpcm\modules\nkorg\example\model\logfile::getLog());
            
            $view->render();
        }

    }