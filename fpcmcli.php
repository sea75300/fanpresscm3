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
     * Konstruktor, prüft PHP-Version, Installer-Status und Datenbank-Config-Status
     * @return void
     */
    public function __construct() {

        $this->output(PHP_EOL.'--- FanPress CM 3 CLI - version '.\fpcm\classes\baseconfig::$fpcmConfig->system_version.' >>> Experimental ---');
        
        if (php_sapi_name() !== 'cli') {
            $this->output('FanPress CM 3 cli must be run from console!', true);
        }

        if (version_compare(PHP_VERSION, FPCM_PHP_REQUIRED, '<')) {
            $this->output('FanPress CM 3 requires PHP '.FPCM_PHP_REQUIRED.' or better!', true);
        }

    }

    public function process($params) {
        
        $module   = ucfirst($params[0]);
        $funcName = 'process'.$module;

        $cli = new fpcm\model\system\cli();
        
        if (!method_exists($cli, $funcName)) {
            $this->output('Invalid module param on position 0.', true);
        }

        $cli->setFuncParams(count($params) ? array_slice($params, 1) : array());

        call_user_func(array($cli, $funcName));
        
    }
    
    private function output($str, $die = false) {
        
        if ($die) {
            die($str.PHP_EOL);
        }
        
        print $str.PHP_EOL;
        
    }
    
}

$cli = new fpcmCLI();
$cli->process(array_slice($argv, 1));