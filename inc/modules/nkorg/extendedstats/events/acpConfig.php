<?php
    /**
     * imagine, https://nobody-knows.org/
     *
     * nkorg/extendedstats event class: acpConfig
     * 
     * @version 0.0.1
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2017, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\extendedstats\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $view = new \fpcm\model\view\module('nkorg/extendedstats', 'acp', 'main');
            $view->setViewJsFiles([
                \fpcm\classes\baseconfig::$rootPath.'inc/modules/'.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__).'/js/chart.min.js',
                \fpcm\classes\baseconfig::$rootPath.'inc/modules/'.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__).'/js/module.js'
            ]);
            
            $counter = new \fpcm\modules\nkorg\extendedstats\model\counter();

            $view->addJsVars(['charValues' => $counter->fetch()]);
            $view->render();
        }

    }