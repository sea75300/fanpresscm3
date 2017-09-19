<?php
    /**
     * Extended statistics
     *
     * nkorg/extendedstats event class: acpConfig
     * 
     * @version 1.0.0
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2017, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\extendedstats\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $chartTypes = [
                $this->lang->translate('NKORG_EXTENDEDSTATS_TYPEBAR')   => 'bar',
                $this->lang->translate('NKORG_EXTENDEDSTATS_TYPELINE')  => 'line',
                $this->lang->translate('NKORG_EXTENDEDSTATS_TYPEPIE')   => 'pie',
                $this->lang->translate('NKORG_EXTENDEDSTATS_TYPEDOUGHNUT')  => 'doughnut',
                $this->lang->translate('NKORG_EXTENDEDSTATS_TYPEPOLAR')     => 'polarArea',
            ];
            
            $view = new \fpcm\model\view\module('nkorg/extendedstats', 'acp', 'main');
            $view->setViewJsFiles([
                \fpcm\classes\baseconfig::$rootPath.'inc/modules/'.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__).'/js/chart.min.js',
                \fpcm\classes\baseconfig::$rootPath.'inc/modules/'.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__).'/js/module.js'
            ]);
            
            $counter = new \fpcm\modules\nkorg\extendedstats\model\counter();
            
            $start     = \fpcm\classes\http::postOnly('dateFrom');
            $stop      = \fpcm\classes\http::postOnly('dateTo');
            $chartType = \fpcm\classes\http::postOnly('chartType');

            $view->assign('start', trim($start) ? $start : '');
            $view->assign('stop', trim($stop) ? $stop : '');
            $view->assign('chartType', trim($chartType) && in_array($chartType, $chartTypes) ? $chartType : 'bar');

            $articleList = new \fpcm\model\articles\articlelist();
            $minMax      = $articleList->getMinMaxDate();

            $view->addJsVars([
                'nkorgExtStatsCharValues' => $counter->fetchArticles($start, $stop),
                'nkorgExtStatsChartType'  => trim($chartType) ? $chartType : 'bar',
                'nkorgExtStatsMinDate'    => date('Y-m-d', $minMax['minDate'])
            ]);
            

            $view->assign('chartTypes', $chartTypes);
            
            
            $view->render();
        }

    }