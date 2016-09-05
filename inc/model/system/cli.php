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
         * CLI param: --clear
         */
        const FPCMCLI_PARAM_CLEAR   = '--clear';

        /**
         * CLI param: --info
         */
        const FPCMCLI_PARAM_INFO    = '--info';

        /**
         * CLI param: --list
         */
        const FPCMCLI_PARAM_LIST    = '--list';

        /**
         * CLI param: --size
         */
        const FPCMCLI_PARAM_SIZE    = '--size';

        /**
         * CLI param: --enable
         */
        const FPCMCLI_PARAM_ENABLE  = '--enable';

        /**
         * CLI param: --disable
         */
        const FPCMCLI_PARAM_DISBALE = '--disable';

        /**
         * CLI param: package manager type: system
         */
        const FPCMCLI_PARAM_TYPE_SYSTEM    = 'system';

        /**
         * CLI param: package manager type: module
         */
        const FPCMCLI_PARAM_TYPE_MODULE    = 'module';

        /**
         * Funktionsparameter
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

        /**
         * CLI: Hilfe ausgeben
         * @return void
         */
        public function processHelp() {
            
            $lines   = array();
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php <module name> <action params> <additional params>';
            $lines[] = '';
            $lines[] = '> Modules:';
            $lines[] = '';
            $lines[] = '      - cache       cache actions';
            $lines[] = '      - cron        cronjob actions';
            $lines[] = '      - logs        logfile actions';
            $lines[] = '      - module      module action';
            $lines[] = '      - pkg         package manager';
            $lines[] = '      - syscheck    system check';
            $lines[] = '      - help        displays this text';
            $lines[] = '';
            $lines[] = '> Example:';
            $lines[] = '';
            $lines[] = '      php fpcmcli.php help';
            $lines[] = '';
            $lines[] = '';
            $lines[] = '> Cache:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php cache <action params> <internal cache name>';
            $lines[] = '';
            $lines[] = '    Action params:';
            $lines[] = '';
            $lines[] = '      --clean       clean up cache';
            $lines[] = '      --size        returns total size of current cache content';
            $lines[] = '      --info        return information of cache expiration time';
            $lines[] = '';
            $lines[] = '> Cronjobs:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php cron <action params> <cronjob name>';
            $lines[] = '';
            $lines[] = '    Action params:';
            $lines[] = '';
            $lines[] = '      --exec        executes given cronjob';
            $lines[] = '';
            $lines[] = '> Package manager:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php pkg <action params> system';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php pkg <action params> module <module key>';
            $lines[] = '';
            $lines[] = '> Action params:';
            $lines[] = '';
            $lines[] = '      --update      updates local package list storage';
            $lines[] = '      --upgrade     upgrades files in local file system and performs database changes from given package';
            $lines[] = '      --upgrade-db  performs database changes from given package';
            $lines[] = '      --install     performs setup of a given package (modules only)';
            $lines[] = '      --remove      performs removal of a given package (modules only)';
            $lines[] = '      --info        displays information about a given package (modules only)';
            $lines[] = '      --list        displays list available packages (modules only)';
            $lines[] = '';
            $lines[] = '> Modules:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php module <action params> <module key>';
            $lines[] = '';
            $lines[] = '    Action params:';
            $lines[] = '';
            $lines[] = '      --enable      enable module';
            $lines[] = '      --disable     disable module';
            $lines[] = '';
            $lines[] = '> Logfiles:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php logs <action params> <logfile name>';
            $lines[] = '';
            $lines[] = '    Action params:';
            $lines[] = '';
            $lines[] = '      --list        show entries of selected logfile';
            $lines[] = '      --clear       clear selected logfile';
            $lines[] = '';
            $lines[] = '> System check:';
            $lines[] = '';
            $lines[] = 'Usage: php (path to FanPress CM/)fpcmcli.php syscheck';
            $lines[] = '';
            $lines[] = '    - The system check has no params to set.';
            $lines[] = '    - Executing the system check via FanPress CM CLI may result in wrong "current" values and check results';
            $lines[] = '      for "PHP memory limit" and "PHP max execution time" due to different settings for web and CLI access in php.ini.';
            $lines[] = '';
            $lines[] = '';

            $this->output($lines);
        }

        /**
         * CLI: Cache Aktionen durchführen
         * @return bool
         */
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
            $moduleList = new \fpcm\model\modules\modulelist();

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

                case self::FPCMCLI_PARAM_INSTALL :
                case self::FPCMCLI_PARAM_UPGRADE :

                    if ($this->funcParams[1] !== self::FPCMCLI_PARAM_TYPE_MODULE && $this->funcParams[0] === self::FPCMCLI_PARAM_INSTALL) {                        
                        $this->output('Invalid params', true);
                    }
                    
                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {

                        $this->output('Start system update...');

                        $successSys = $updaterSys->checkUpdates();
                        $remoteData = $updaterSys->getRemoteData();

                        $fileInfo = pathinfo($remoteData['filepath'], PATHINFO_FILENAME);

                        $pkg = new \fpcm\model\packages\update('update', $fileInfo);
                    
                    }
                    elseif ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_MODULE) {                        

                        $list       = $moduleList->getModulesRemote();
                        $keyData    = \fpcm\model\packages\package::explodeModuleFileName($this->funcParams[2]);

                        if (!array_key_exists($keyData[0], $list)) {
                            $this->output('The requested module was not found in package list storage. Check your module key or update package information storage.', true);
                        }

                        /* @var $module \fpcm\model\modules\listitem */
                        $module = $list[$keyData[0]];                        
                        $pkg     = new \fpcm\model\packages\module('module', $module->getKey(), $module->getVersionRemote());
                    }

                    $this->output('Download package from '.$pkg->getRemoteFile().'...');

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

                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {
                        $this->output('Run final update steps...');
                        $this->runFinalizer();                        
                    }
                    elseif ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_MODULE) {

                        $this->output('Perform database changes...');

                        $moduleClass = \fpcm\model\abstracts\module::getModuleClassName($keyData[0]);
                        $res = class_exists($moduleClass);

                        $moduleClassPath = \fpcm\classes\baseconfig::$moduleDir.$keyData[0].'/'.str_replace(array('\\', '/'), '', $keyData[0]).'.php';
                        if (!file_exists($moduleClassPath)) {
                            $this->output('Module class '.$moduleClass.' not found in "'.$moduleClassPath.'"!', true);
                        }

                        $modObj = new $moduleClass($pkg->getKey(), '', $module->getVersionRemote());                        
                        if (!is_a($modObj, '\fpcm\model\abstracts\module'))  {
                            $this->output('Module class '.$moduleClass.' must be an instance of "\fpcm\model\abstracts\module"!', true);
                        }

                        if ($this->funcParams[0] === self::FPCMCLI_PARAM_INSTALL) {
                            if ($module->isInstalled()) {
                                $this->output('The selected module is already installed. Exiting...', true);
                            }                            
                            $res = $modObj->runInstall();
                        }
                        elseif ($this->funcParams[0] === self::FPCMCLI_PARAM_UPGRADE) {
                            if (!$module->isInstalled()) {
                                $this->output('The selected module is not installed. Exiting...', true);
                            }
                            $res = $modObj->runUpdate();
                        }

                    }

                    $this->output('Update package manager log...');
                    $pkg->loadPackageFileListFromTemp();
                    \fpcm\classes\logs::pkglogWrite($pkg->getKey().' '.$pkg->getVersion(), $pkg->getFiles());

                    $this->output('Perform cleanup...');
                    $success = $pkg->cleanup();

                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {
                        $this->output('System update successfull. New version: '.$this->config->system_version);
                    }

                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_MODULE) {
                        $this->output('Module installed successfull!');
                    }
                    
                    break;

                case self::FPCMCLI_PARAM_UPGRADE_DB :
                    
                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_MODULE) {
                        $this->output('Invalid params', true);
                    }
                    
                    if ($this->funcParams[1] === self::FPCMCLI_PARAM_TYPE_SYSTEM) {

                        $this->output('Update database and filesystem...');
                        $this->runFinalizer();
                        
                        $this->output('Update successfull. New version: '.$this->config->system_version);

                    }                    
                    
                    break;
                    
                case self::FPCMCLI_PARAM_REMOVE :
                    
                    if ($this->funcParams[1] !== self::FPCMCLI_PARAM_TYPE_MODULE) {                        
                        $this->output('Invalid params', true);
                    }
                    
                    $list       = $moduleList->getModulesRemote();
                    $keyData    = \fpcm\model\packages\package::explodeModuleFileName($this->funcParams[2]);
                    
                    if (!array_key_exists($keyData[0], $list)) {
                        $this->output('The requested module was not found in package list storage. Check your module key or update package information storage.', true);
                    }

                    /* @var $module \fpcm\model\modules\listitem */
                    $module = $list[$keyData[0]];                    
                    if (!$module->isInstalled()) {
                        $this->output('The selected module is not installed. Exiting...', true);
                    }

                    $module->runUninstall();
                    
                    if (!$moduleList->uninstallModules(array($keyData[0]))) {
                        $this->output('Unable to remove module '.$keyData[0], true);
                    }

                    $this->output('Module '.$keyData[0].' was removed successfully.');

                    break;
                    
                case self::FPCMCLI_PARAM_LIST :
                    
                    if ($this->funcParams[1] !== self::FPCMCLI_PARAM_TYPE_MODULE) {                        
                        $this->output('Invalid params', true);
                    }

                    $list = $moduleList->getModulesRemote(false);

                    $out = array('', 'Available modules from package server for current FanPress CM version:', '');
                    
                    /* @var $value \fpcm\model\modules\listitem */
                    foreach ($list as $value) {
                        $line = array(
                            '   == '.$value->getName().' > '.$value->getKey().', '.$value->getVersionRemote(),
                            '   '.$value->getAuthor().' > '.$value->getLink(),
                            '   '.$value->getDescription(),
                            ''
                        );
                        
                        $out[] = implode(PHP_EOL, $line);
                    }
                    
                    $this->output($out);
                    
                    break;
                    
                case self::FPCMCLI_PARAM_INFO :

                    if ($this->funcParams[1] !== self::FPCMCLI_PARAM_TYPE_MODULE) {                        
                        $this->output('Invalid params', true);
                    }

                    $list       = $moduleList->getModulesRemote();
                    
                    $keyData    = \fpcm\model\packages\package::explodeModuleFileName($this->funcParams[2]);
                    
                    if (!array_key_exists($keyData[0], $list)) {
                        $this->output('The requested module was not found in package list storage. Check your module key or update package information storage.', true);
                    }

                    /* @var $module \fpcm\model\modules\listitem */
                    $module = $list[$keyData[0]];
                    
                    $this->output(array(
                        '== '.$module->getName(),
                        '   '.$module->getKey(),
                        '   > '.$module->getDescription(),
                        '   Version: '.$module->getVersionRemote(),
                        '   Author: '.$module->getAuthor(),
                        '   Link: '.$module->getLink(),
                        '   Installed: '.($module->isInstalled() ? 'yes' : 'no'),
                        '   Installed version: '.$module->getVersion(),
                        '   Status: '.($module->getStatus() ? 'enabled' : 'disabled'),
                        '   Dependencies:',
                        '   '.implode(PHP_EOL, $module->getDependencies())
                    ));

                    
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

        /**
         * Cronjob Ausführung
         * @return boolean
         */
        public function processModule() {

            $moduleList = new \fpcm\model\modules\modulelist();
            $list       = $moduleList->getModulesLocal();

            $keyData    = \fpcm\model\packages\package::explodeModuleFileName($this->funcParams[1]);

            if (!array_key_exists($keyData[0], $list)) {
                $this->output('The requested module was not found in local module storage. Check your module key.', true);
            }

            /* @var $module \fpcm\model\modules\listitem */
            $module = $list[$keyData[0]];                    
            if (!$module->isInstalled()) {
                $this->output('The selected module is not installed. Exiting...', true);
            }

            if ($this->funcParams[0] === self::FPCMCLI_PARAM_ENABLE) {
                if (!$moduleList->enableModules(array($keyData[0]))) {
                    $this->output('Unable to enable module '.$keyData[0], true);
                }

                $this->output('Module '.$keyData[0].' was enabled successfully.');

            }

            if ($this->funcParams[0] === self::FPCMCLI_PARAM_DISBALE) {
                if (!$moduleList->disableModules(array($keyData[0]))) {
                    $this->output('Unable to disable module '.$keyData[0], true);
                }

                $this->output('Module '.$keyData[0].' was disableed successfully.');
            }
            
            return true;

        }

        /**
         * Logfiles auswerten
         * @return boolean
         */
        public function processLogs() {

            if (!isset($this->funcParams[1]) || !trim($this->funcParams[1])) {
                $this->output('Invalid params', true);
            }
            
            $path = \fpcm\classes\baseconfig::$logDir.$this->funcParams[1].'.txt';
            
            $this->output('--- Logfile: '.\fpcm\model\files\ops::removeBaseDir($path, true).' ---');
            
            if (!file_exists($path) || !in_array($path, \fpcm\classes\baseconfig::$logFiles)) {
                $this->output('Logfile '.\fpcm\model\files\ops::removeBaseDir($path, true).' not found!', true);
            }
            
            if ($this->funcParams[0] === self::FPCMCLI_PARAM_CLEAR && !file_put_contents($path, '') === false) {
                $this->output('Unable to clear logfile '.\fpcm\model\files\ops::removeBaseDir($path, true).'!', true);
            }
            
            $rows = file($path, FILE_SKIP_EMPTY_LINES);
            if (!is_array($rows)) {
                $this->output('Unable to load logfile '.\fpcm\model\files\ops::removeBaseDir($path, true).'!', true);
            }
            
            if (!count($rows)) {
                $this->output('     >> No data available...');
                return true;
            }
            
            $rows = array_map('json_decode', $rows);
            
            $is_pkg_log = ($path === \fpcm\classes\baseconfig::$logFiles['pkglog'] ? true : false);
            if ($this->funcParams[0] === self::FPCMCLI_PARAM_LIST) {

                foreach ($rows as $row) {

                    if (!is_object($row)) {
                        continue;
                    }

                    $this->output('Entry added on: '.$row->time);
                    if ($is_pkg_log) {
                        $this->output('Package name: '.$row->pkgname);
                    }

                    $this->output($row->text);
                    $this->output('-----');

                }

            }
            
            return true;

        }
        
        /**
         * Logfiles auswerten
         * @return boolean
         */
        public function processSyscheck() {

            \fpcm\classes\baseconfig::$fpcmLanguage = new \fpcm\classes\language('en');
            
            $sysCheckAction = new \fpcm\controller\ajax\system\syscheck();
            $rows = $sysCheckAction->processCli();

            $this->output(PHP_EOL.'Executing system check...'.PHP_EOL);
            
            $lines = array();
            foreach ($rows as $descr => $data) {
                
                $line = array(
                    '> '.strip_tags($descr),
                    '   current value     : '.(string) $data['current'],
                    '   recommended value : '.(string) $data['recommend'],
                    '   result            : '.($data['result'] ? 'OK' : '!!'),
                isset($data['notice']) && trim($data['notice']) ? '   '.$data['notice'].PHP_EOL : ''
                );
                
                $lines[] = implode(PHP_EOL, $line);
            }

            $this->output($lines);
        }

        /**
         * CLI Ausgabe
         * @param string $str
         * @param bool $die
         */
        private function output($str, $die = false) {

            if (is_array($str)) {
                $str = implode(PHP_EOL, $str);
            }
            
            if ($die) {
                die($str.PHP_EOL);
            }

            print $str.PHP_EOL;

        }
    }
