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
            
            $chartModes = [
                $this->lang->translate('NKORG_EXTENDEDSTATS_BYYEAR')  => \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_YEAR,
                $this->lang->translate('NKORG_EXTENDEDSTATS_BYMONTH') => \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_MONTH,
                $this->lang->translate('NKORG_EXTENDEDSTATS_BYDAY')   => \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_DAY
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

            $chartMode = \fpcm\classes\http::postOnly('chartMode', [
                \fpcm\classes\http::FPCM_REQFILTER_CASTINT
            ]);
            

            $modeStr =  $chartMode === \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_YEAR
                    ? 'YEAR'
                    : ($chartMode === \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_DAY
                    ? 'DAY'
                    : 'MONTH'
            );
            
            
            $view->assign('modeStr', $modeStr);

            $view->assign('start', trim($start) ? $start : '');
            $view->assign('stop', trim($stop) ? $stop : '');
            $view->assign('chartType', trim($chartType) && in_array($chartType, $chartTypes) ? $chartType : 'bar');
            $view->assign('chartMode', in_array($chartMode, $chartModes) ? $chartMode : \fpcm\modules\nkorg\extendedstats\model\counter::FPCM_NKORG_EXTSTATS_MODE_MONTH);

            $articleList = new \fpcm\model\articles\articlelist();
            $minMax      = $articleList->getMinMaxDate();

            $view->addJsVars([
                'nkorgExtStatsCharValues' => $counter->fetchArticles($start, $stop, $chartMode),
                'nkorgExtStatsChartType'  => trim($chartType) ? $chartType : 'bar',
                'nkorgExtStatsMinDate'    => date('Y-m-d', $minMax['minDate'])
            ]);

            $view->assign('chartTypes', $chartTypes);
            $view->assign('chartModes', $chartModes);
            
            
            $view->render();
        }

    }