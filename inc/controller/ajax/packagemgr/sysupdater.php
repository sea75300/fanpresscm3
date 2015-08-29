<?php
    /**
     * AJAX system updates controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\packagemgr;
    
    /**
     * AJAX-Controller Paketmanager - System-Updater
     * 
     * @package fpcm.controller.ajax.packagemgr.sysupdater
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */      
    class sysupdater extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Auszuführender Schritt
         * @var int
         */
        protected $step;
        
        /**
         * allow_url_fopen = 1
         * @var bool
         */
        protected $canConnect;

        /**
         * Konstruktur
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            
            $this->step = (int) $this->getRequestVar('step');
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {

            if (!parent::process()) return false;

            $this->canConnect   = \fpcm\classes\baseconfig::canConnect();
            
            if ($this->canConnect) {
                $updater = new \fpcm\model\updater\system();
                $updater->checkUpdates();

                $remoteData = $updater->getRemoteData();

                $fileInfo = pathinfo($remoteData['filepath'], PATHINFO_FILENAME);

                $tmpFile = new \fpcm\model\files\tempfile('forceUpdateFile');
                if ($tmpFile->exists()) {
                    $fileInfo = $tmpFile->getContent();
                }

                $signature = isset($remoteData['signature']) ? $remoteData['signature'] : '';
                $pkg = new \fpcm\model\packages\package('update', $fileInfo, '', $signature);
            }            
            
            switch ($this->step) {
                case 1 :
                    $res = $pkg->download();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Downloaded update package successfully!');
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while downloading update package!');
                    }
                    break;
                case 2 :
                    $res = $pkg->extract();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Extracted update package successfully!');
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while extracting update package!');
                    }
                    break;
                case 3 :
                    $res = $pkg->copy();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Moved update package content successfully!');
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while moving update package content!');
                    }
                    break;
                case 4 :
                    $finalizer = new \fpcm\model\updater\finalizer();
                    $res = $finalizer->runUpdate();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Run final update steps successfully!');
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while running final update steps!');
                    }
                    break;
                case 5 :
                    if ($this->canConnect) {
                        $pkg->loadPackageFileListFromTemp();
                        $files = $pkg->getFiles();
                        $pkg->cleanup();
                        \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                        die('<ul class="fpcm-updater-list-files fpcm-hidden"><li>'.implode('</li><li>', $files).'</li></ul>');
                    }
                    
                    \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                    $this->cache->cleanup();
                    die();
                    
                    break;                
                default:
                    $res = false;
                    break;
            }

            die($this->step.'_'.(int) $res);
            
        }
    }
?>