<?php
    /**
     * System updater controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\packagemgr;
    
    class sysupdate extends \fpcm\controller\abstracts\controller {

        use \fpcm\controller\traits\packagemgr\initialize;
        
        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;
        
        /**
         * Update-Prüfung aktiv
         * @var bool
         */
        protected $updateCheckEnabled = false;
        
        /**
         * Auszuführender Schritt
         * @var int
         */
        protected $forceStep = false;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();

            $this->checkPermission  = array('system' => 'update');
            $this->view             = new \fpcm\model\view\acp('sysupdater', 'packagemgr');
        }
        
        /**
         * Request-Handler
         * @return bool
         */
        public function request() {
            if ($this->getRequestVar('step')) {
                $this->forceStep = (int) $this->getRequestVar('step');
            }
            
            if ($this->getRequestVar('file')) {
                $tmpFile = new \fpcm\model\files\tempfile('forceUpdateFile', $this->getRequestVar('file'));
                $tmpFile->save();
            }
            
            if (!$this->forceStep) {
                \fpcm\classes\baseconfig::enableAsyncCronjobs(false);
            }
            
            return parent::request();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            if (!is_writable(\fpcm\classes\baseconfig::$versionFile)) {
                $this->view->addErrorMessage('UPDATE_WRITEERROR');
                $this->view->assign('nofade', true);
                $this->view->render();
                return false;
            }
            
            $this->config->setMaintenanceMode(false);
            
            $updater = new \fpcm\model\updater\system();            
            $updater->checkUpdates();
            $remoteFilePath = $updater->getRemoteData('filepath');
            
            $params     = $this->initPkgManagerData();
            $params['fpcmUpdaterStartStep']           = ($this->forceStep ? $this->forceStep : (\fpcm\classes\baseconfig::canConnect() ? 1 : 4));
            $params['fpcmUpdaterNewVersion']          = $this->lang->translate('PACKAGES_UPDATE_NEW_VERSION');
            $params['fpcmUpdaterMessages']['1_START'] = $this->lang->translate('PACKAGES_RUN_DOWNLOAD', array('{{pkglink}}' => is_array($remoteFilePath) ? '' : $remoteFilePath));
            $params['fpcmUpdaterMessages']['EXIT_1']  = $this->lang->translate('UPDATES_SUCCESS');
            
            $this->view->addJsVars($params);
            
            $this->view->setViewJsFiles(array(\fpcm\classes\baseconfig::$jsPath.'updater.js'));
            
            $this->view->render();
        }

    }