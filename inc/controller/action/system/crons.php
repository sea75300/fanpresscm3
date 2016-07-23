<?php
    /**
     * Cronjob manager controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class crons extends \fpcm\controller\abstracts\controller {
        
        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();

            $this->checkPermission = array('system' => 'crons');
            $this->view   = new \fpcm\model\view\acp('cronjobs', 'system');

        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;
            
            $conjobIntervals = array(
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_0')          => 0,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_60')         => 60,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_90')         => 90,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_120')        => 120,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_300')        => 300,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_600')        => 600,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_900')        => 900,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_1800')       => 1800,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_3600')       => 3600,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_7200')       => 7200,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_10800')      => 10800,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_21600')      => 21600,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_43200')      => 43200,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_86400')      => 86400,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_172800')     => 172800,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_604800')     => 604800,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_1209600')    => 1209600,
                $this->lang->translate('SYSTEM_OPTIONS_INTERVAL_2419200')    => 2419200
            );

            $cronlist = new \fpcm\model\crons\cronlist();
            $this->view->assign('cronjobList', $cronlist->getCronsData());
            $this->view->assign('currentTime', time());
            $this->view->assign('conjobIntervals', $conjobIntervals);
            $this->view->render();
            
            $this->view->render();
        }
        
    }
?>
