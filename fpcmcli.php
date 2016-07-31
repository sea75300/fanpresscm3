<?php

require_once __DIR__.'/inc/common.php';

/**
 * FanPress CM cli class
 * 
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @package fpcmcli
 * @since FPCM 3.3
 */    
class fpcmCLI {

    /**
     * CLI param: install
     */
    const FPCMCLI_PARAM_INSTALL = '--install';
    
    /**
     * CLI param: update
     */
    const FPCMCLI_PARAM_UPDATE  = '--update';
    
    /**
     * CLI param: upgrade
     */
    const FPCMCLI_PARAM_UPGRADE = '--upgrade';

    /**
     * CLI param: remove
     */
    const FPCMCLI_PARAM_REMOVE  = '--remove';
    
    /**
     * Interner Funktionsname, abhängig von erstem Parameter
     * @var string
     */
    protected $funcName;

    /**
     *
     * @var array
     */
    protected $funcParams;


    /**
     * Konstruktor, prüft PHP-Version, Installer-Status und Datenbank-Config-Status
     * @return void
     */
    public function __construct() {

        if (php_sapi_name() !== 'cli') {
            $this->output('FanPress CM 3 cli must be run from console!', true);
        }

        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $this->output('FanPress CM 3 requires PHP 5.4.0 or better!', true);
        }
        
        $this->output('Experimental FanPress CM cli. Unfinished!');

    }

    public function process($params) {
        
        $module         = ucfirst($params[0]);
        $this->funcName = 'process'.$module;

        $this->funcExists($this->funcName, 1);

        
        $this->funcParams = count($params) ? array_slice($params, 1) : array();
        
        
        print_r($this->funcParams);
        
        
        call_user_func(array($this, $this->funcName));
        
    }
    
    private function funcExists($funcName, $paramPos) {

        if (method_exists($this, $funcName)) {
            return true;
        }

        $this->output('Invalid module param on position '.$paramPos, true);

    }
    
    private function output($str, $die = false) {
        
        if ($die) {
            die($str.PHP_EOL);
        }
        
        print $str.PHP_EOL;
        
    }

    private function processPkg() {

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

                if ($this->funcParams[1] === 'system') {
                    
                    $this->output('Start system update...');
                    
                    $successSys = $updaterSys->checkUpdates();
                    $remoteData = $updaterSys->getRemoteData();

                    $fileInfo = pathinfo($remoteData['filepath'], PATHINFO_FILENAME);
                    
                    $pkg = new fpcm\model\packages\update('update', $fileInfo);
                    
                    $this->output('Download '.$remoteData['filepath'].'...');
                    $success = $pkg->download();
                    if ($success !== true) {
                        $this->output('Download failed. ERROR CODE: '.$success, true);
                    }
                    
                    $this->output('Unpacking...');
                    $success = $pkg->extract();
                    if ($success !== true) {
                        $this->output('Unpacking failed. ERROR CODE: '.$success, true);
                    }   
                }

            default:
                break;
        }
        
    }
    
    
}

$cli = new fpcmCLI();
$cli->process(array_slice($argv, 1));