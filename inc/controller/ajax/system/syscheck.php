<?php
    /**
     * AJAX syscheck controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
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
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();
            
            $view = new \fpcm\model\view\ajax('syscheck', 'system');
            $view->initAssigns();

            $view->assign('checkOptions', $this->getCheckOptions());
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
                'helplink'  => 'http://nobody-knows.org/download/fanpress-cm/',
                'actionbtn' => array('link' => $this->getControllerLink('package/sysupdate'), 'description' => 'PACKAGES_UPDATE'),
            );      
            
            if (!$this->permissions->check(array('system' => 'update'))) {
                unset($checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION')]['actionbtn']);
            }
            
            $checkOptions = array_merge($checkOptions, $this->getCheckOptionsSystem());

            return $this->events->runEvent('runSystemCheck', $checkOptions);;
        }
        
    }
?>