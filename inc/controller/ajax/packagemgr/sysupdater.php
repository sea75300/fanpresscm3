<?php
    /**
     * AJAX system updates controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
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
         * bestimmten Schritt erzwingen
         * @var int
         */
        protected $forceStep;
        
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
            
            $this->step = $this->getRequestVar('step', array(9));          
            $this->forceStep = $this->getRequestVar('force', array(9));
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {

            if (!parent::process()) return false;

            $this->canConnect   = \fpcm\classes\baseconfig::canConnect();
            
            if ($this->canConnect) {
                
                $versionDataFile = new \fpcm\model\files\tempfile('newversion');
                if ($versionDataFile->exists() && $versionDataFile->getContent()) {
                    $remoteData = json_decode($versionDataFile->getContent(), true);
                }
                else {
                    $updater = new \fpcm\model\updater\system();
                    $updater->checkUpdates();

                    $remoteData = $updater->getRemoteData();
                    $versionDataFile->setContent(json_encode($remoteData));
                    $versionDataFile->save();
                }

                $fileInfo = pathinfo($remoteData['filepath'], PATHINFO_FILENAME);

                $tmpFile = new \fpcm\model\files\tempfile('forceUpdateFile');
                if ($tmpFile->exists()) {
                    $fileInfo = $tmpFile->getContent();
                }

                $signature = isset($remoteData['signature']) ? $remoteData['signature'] : '';
                $pkg = new \fpcm\model\packages\update('update', $fileInfo, '', $signature);
            }

            $this->returnData['current'] = $this->step;
            
            switch ($this->step) {
                case 1 :
                    $res = $pkg->download();
                    
                    if ($res === \fpcm\model\packages\package::FPCMPACKAGE_REMOTEFILE_ERROR) {
                        $versionDataFile->delete();
                    }
                    
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Downloaded update package successfully from '.$pkg->getRemoteFile());
                        $this->returnData['nextstep'] = 2;
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while downloading update package from '.$pkg->getRemoteFile());
                        $this->returnData['nextstep'] = 5;
                    }
                    break;
                case 2 :
                    $res = $pkg->extract();
                    $from = \fpcm\model\files\ops::removeBaseDir($pkg->getLocalFile());
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Extracted update package successfully from '.$from);
                        $this->returnData['nextstep'] = 3;
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while extracting update package from '.$from);
                        $this->returnData['nextstep'] = 5;
                    }
                    break;
                case 3 :
                    $res = $pkg->copy();
                    $dest = \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$baseDir);
                    $from = \fpcm\model\files\ops::removeBaseDir($pkg->getExtractPath());
                    if ($res === true) {                        
                        \fpcm\classes\logs::syslogWrite('Moved update package content successfully from '.$from.' to '.$dest);
                        $this->returnData['nextstep'] = 4;
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while moving update package content from '.$from.' to '.$dest);
                        \fpcm\classes\logs::syslogWrite($pkg->getCopyErrorPaths());
                        $this->returnData['nextstep'] = 5;
                    }
                    break;
                case 4 :
                    $finalizer = new \fpcm\model\updater\finalizer();
                    $res = $finalizer->runUpdate();
                    $this->returnData['nextstep'] = $this->forceStep ? 6 : 5;

                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Run final update steps successfully!');
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while running final update steps!');
                    }
                    break;
                case 5 :
                    if ($this->canConnect) {
                        $pkg->loadPackageFileListFromTemp();
                        \fpcm\classes\logs::pkglogWrite($pkg->getKey().' '.$pkg->getVersion(), $pkg->getFiles());
                        $pkg->cleanup();
                        $versionDataFile->delete();
                    }
                    
                    \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                    $this->cache->cleanup();

                    $res = true;
                    $this->returnData['nextstep'] = 6;

                    break;                
                case 6 :

                    $this->returnData['newver'] = $this->config->system_version;
                    $res = true;

                    break;
                default:
                    $res = false;
                    break;
            }

            $this->returnCode = $this->step.'_'.(int) $res;
            $this->getResponse();
        }
    }
?>