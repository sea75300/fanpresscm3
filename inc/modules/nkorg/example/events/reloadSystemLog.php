<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: reloadSystemLog
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class reloadSystemLog extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            if ($params !== 'nkorgexample') {
                return false;
            }

            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__), 'ajax', 'logview');
            $view->assign('logfiledata', \fpcm\modules\nkorg\example\model\logfile::getLog());
            
            $view->render();
            
        }

    }