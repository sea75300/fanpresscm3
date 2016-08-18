<?php
    /**
     * AJAX syscheck controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\system;
    
    /**
     * AJAX-Controller - System Check
     * 
     * @package fpcm.controller.ajax.system.syscheck
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */  
    class syscheck extends \fpcm\controller\abstracts\ajaxController {
        
        use \fpcm\controller\traits\system\syscheck;
        
        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var bool
         */
        protected $installer;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
        }

        public function request() {

            if (!\fpcm\classes\baseconfig::installerEnabled() && \fpcm\classes\baseconfig::dbConfigExists() && !$this->session->exists()) {
                return false;
            }
            
            return true;
        }

        
        /**
         * Controller-Processing
         */
        public function process() {
            
            $view = new \fpcm\model\view\ajax('syscheck', 'system');
            $view->initAssigns();

            $view->assign('checkOptions', $this->getCheckOptions());
            $view->assign('installer', false);
            $view->render();

        }
        
        /**
         * System-Check-Optionen ermitteln
         * @return array
         */
        private function getCheckOptions() {
            $checkOptions     = array();            
            
            $updater = new \fpcm\model\updater\system();
            $updater->checkUpdates();
            
            $remoteVersion = $updater->getRemoteData('version');
            
            $checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION')]    = array(
                'current'   => $this->config->system_version,
                'recommend' => $remoteVersion ? $remoteVersion : $this->lang->translate('GLOBAL_NOTFOUND'),
                'result'    => version_compare($this->config->system_version, $remoteVersion, '>='),
                'helplink'  => 'https://nobody-knows.org/download/fanpress-cm/',
                'actionbtn' => array('link' => $this->getControllerLink('package/sysupdate'), 'description' => 'PACKAGES_UPDATE'),
            );      
            
            if (!$this->permissions->check(array('system' => 'update'))) {
                unset($checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION')]['actionbtn']);
            }
            
            $checkOptions = array_merge($checkOptions, $this->getCheckOptionsSystem());

            return $this->events->runEvent('runSystemCheck', $checkOptions);
        }
        
        public function processCli() {
            
            $checkOptions     = array();            
            
            $updater = new \fpcm\model\updater\system();
            $updater->checkUpdates();
            
            $remoteVersion = $updater->getRemoteData('version');

            $versionCheckresult = version_compare($this->config->system_version, $remoteVersion, '>=');
            $checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION')] = array(
                'current'   => $this->config->system_version,
                'recommend' => $remoteVersion ? $remoteVersion : $this->lang->translate('GLOBAL_NOTFOUND'),
                'result'    => $versionCheckresult,
                'notice'    => !$versionCheckresult ? 'You may run       : php '.\fpcm\classes\baseconfig::$baseDir.'fpcmcli.php pkg --upgrade system' : ''
            );      

            $checkOptions = array_merge($checkOptions, $this->getCheckOptionsSystem());

            return $this->events->runEvent('runSystemCheck', $checkOptions);
            
        }
        
    }
?>