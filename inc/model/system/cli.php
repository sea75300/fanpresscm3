<?php
    namespace fpcm\model\system;

    /**
     * FanPress CM cli object
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.3
     */
    class cli extends \fpcm\model\abstracts\staticModel {

        /**
         * CLI param: --install
         */
        const FPCMCLI_PARAM_INSTALL = '--install';

        /**
         * CLI param: --update
         */
        const FPCMCLI_PARAM_UPDATE  = '--update';

        /**
         * CLI param: --upgrade
         */
        const FPCMCLI_PARAM_UPGRADE = '--upgrade';

        /**
         * CLI param: --upgrade-db
         */
        const FPCMCLI_PARAM_UPGRADE_DB = '--upgrade-db';

        /**
         * CLI param: --remove
         */
        const FPCMCLI_PARAM_REMOVE  = '--remove';

        /**
         * CLI param: --exec
         */
        const FPCMCLI_PARAM_EXEC    = '--exec';

        /**
         * CLI param: --clean
         */
        const FPCMCLI_PARAM_CLEAN   = '--clean';

        /**
         * CLI param: --info
         */
        const FPCMCLI_PARAM_INFO    = '--info';

        /**
         * CLI param: --size
         */
        const FPCMCLI_PARAM_SIZE    = '--size';

        /**
         * CLI param: package manager type: system
         */
        const FPCMCLI_PARAM_TYPE_SYSTEM    = 'system';

        /**
         * CLI param: package manager type: module
         */
        const FPCMCLI_PARAM_TYPE_MODULE    = 'module';

        /**
         *
         * @var array
         */
        protected $funcParams = array();

        /**
         * Parameter für Funktion
         * @param array $funcParams
         */
        function setFuncParams(array $funcParams) {
            $this->funcParams = $funcParams;
        }

        public function processCache() {
            
            $cacheName = $this->funcParams[1] === 'all' ? null : $this->funcParams[1];
            $cache     = new \fpcm\classes\cache($cacheName);
            
            if ($this->funcParams[0] === self::FPCMCLI_PARAM_CLEAN) {
                $cache->cleanup($cacheName === null ? false : $cacheName);
                $this->output('Cache was cleared!');
                return true;
            }

            if ($this->funcParams[0] === self::FPCMCLI_PARAM_INFO) {
                $this->output('Cache expiration interval: '.date('Y-m-d H:i:s', $cache->getExpirationTime()));
                $this->output('Cache is expired: '.(int) $cache->isExpired());
                return true;
            }

            if ($this->funcParams[0] === self::FPCMCLI_PARAM_SIZE) {
                $this->output('Cache total size: '.\fpcm\classes\tools::calcSize($cache->getSize()));
                return true;
            }
   
        }

        /**
         * Paket Manager Aktionen
         * @return boolean
         */
        public function processPkg() {

            $updaterSys = new \fpcm\model\updater\system();
            $updaterMod = new \fpcm\model\updater\modules();

            switch ($this->funcParams[0]) {

                case self::FPCMCLI_PARAM_UPDATE :

                    $this->output('Check for system and module updates...');

                    $successSys = $updaterSys->checkUpdates();
                    $successMod = $updaterMod->checkUpdates();

                    if ($successSys > 1 || $successMod > 1) {
                        $this->output('Unable to update package informations. Check PHP log for further information.'.PHP_EOL.'Error Code: SYS-'.$successSys.' | MOD-'.$successMod, true);
                    }

                    $this->output('Check successfull!');
                    $this->output('Current system version: '.$updaterSys->getRemoteData('version'));
                    $this->output('Module updates available: '.($successMod ? 'yes' : 'no'));

                    break;

                case self::FPCMCLI_PARAM_UPGRADE :

                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {

                        $this->output('Start system update...');

                        $successSys = $updaterSys->checkUpdates();
                        $remoteData = $updaterSys->getRemoteData();

                        $fileInfo = pathinfo($remoteData['filepath'], PATHINFO_FILENAME);

                        $pkg = new \fpcm\model\packages\update('update', $fileInfo);

                        $this->output('Download package from '.$remoteData['filepath'].'...');
                        $success = $pkg->download();
                        if ($success !== true) {
                            $this->output('Download failed. ERROR CODE: '.$success, true);
                        }

                        $this->output('Unpacking package file '.\fpcm\model\files\ops::removeBaseDir($pkg->getLocalFile(), true).'...');
                        $success = $pkg->extract();
                        if ($success !== true) {
                            $this->output('Unpacking failed. ERROR CODE: '.$success, true);
                        }

                        $this->output('Copy package content...');
                        $success = $pkg->copy();
                        if ($success !== true) {
                            $this->output('Copy process failed. ERROR CODE: '.$success, true);
                        }

                        $this->output('Run final update steps...');
                        $this->runFinalizer();
                        
                        $this->output('Update package manager log...');
                        $pkg->loadPackageFileListFromTemp();
                        \fpcm\classes\logs::pkglogWrite($pkg->getKey().' '.$pkg->getVersion(), $pkg->getFiles());
                        
                        $this->output('Perform cleanup...');
                        $success = $pkg->cleanup();
                        if ($success !== true) {
                            $this->output('Cleanup package data. ERROR CODE: '.$success, true);
                        }
                        
                        $this->output('System update successfull. New version: '.$this->config->system_version);
                    }
                    
                case self::FPCMCLI_PARAM_UPGRADE_DB :
                    
                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {

                        $this->output('Update database and filesystem...');
                        $this->runFinalizer();
                        
                        $this->output('Update successfull. New version: '.$this->config->system_version);

                    }
                    
                    
                    break;

                default:
                    break;
            }

            return true;

        }

        /**
         * Run update finalizer
         * @return boolean
         */
        private function runFinalizer() {

            $finalizer = new \fpcm\model\updater\finalizer();
            $success = $finalizer->runUpdate();
            if ($success !== true) {
                $this->output('Error while running final update steps. ERROR CODE: '.$success, true);
            }
            
            $this->config->init();
            
            return true;
        }

        /**
         * Cronjob Ausführung
         * @return boolean
         */
        public function processCron() {

            if ($this->funcParams[0] === self::FPCMCLI_PARAM_EXEC) {

                $cjClassName = "\\fpcm\\model\\crons\\{$this->funcParams[1]}";

                /* @var $cronjob \fpcm\model\abstracts\cron */
                $cronjob = new $cjClassName($this->funcParams[1]);

                if (!is_a($cronjob, '\fpcm\model\abstracts\cron')) {
                    $this->output("Cronjob class {$this->funcParams[1]} must be an instance of \"\fpcm\model\abstracts\cron\"!", true);             
                }

                $this->output('Execute cronjob '.$this->funcParams[1]);
                $success = $cronjob->run();

                $cronjob->updateLastExecTime();

                $this->output('Cronjob execution finished. Returned code: '.$success);

            }
            
            return true;

        }
    
        private function output($str, $die = false) {

            if ($die) {
                die($str.PHP_EOL);
            }

            print $str.PHP_EOL;

        }
    }
