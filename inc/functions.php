<?php
    /**
     * Base functions
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    /**
     * FanPress CM Class Autolaoder
     * @param string $class
     */
    function fpcmAutoLoader($class) {
        if (strpos($class, 'fpcm') === false) {
            return false;
        }

        $class = str_replace(array('fpcm\\', '\\'), array('', DIRECTORY_SEPARATOR), $class);
        $includePath = fpcm\classes\baseconfig::$baseDir.DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR.$class.'.php';
        
        if (file_exists($includePath)) {
            include_once $includePath;
            return true;   
        }
        
        $includePaths = array('controller', 'model', 'classes', 'modules');
        foreach ($includePaths AS $path) {            
            $includePath = fpcm\classes\baseconfig::$incDir.$path.DIRECTORY_SEPARATOR.$class.'.php';
            if (!file_exists($includePath)) {
                continue;
            }
            include_once $includePath;
            break;
        } 
        
        return true;
    }
    
    /**
     * FanPress CM Error Handler
     * @param string $ecode Error-Code
     * @param string $etext Error-Text
     * @param string $efile Error-File
     * @param string $eline Error-File-Line
     * @return boolean
     */
    function fpcmErrorHandler($ecode, $etext, $efile, $eline) {        
        $errorLog = dirname(__DIR__).'/data/logs/phplog.txt';
        
        if (!is_writable($errorLog)) {
            return false;
        }
        
        $text = array($etext, 'in file '.$efile.', line '.$eline, 'ERROR CODE: '.$ecode);
        
        $LogLine = json_encode(array('time' => date('Y-m-d H:i:s'), 'text' => implode(PHP_EOL, $text)));
        file_put_contents($errorLog, $LogLine.PHP_EOL, FILE_APPEND);

        return true;
    }
    
    /**
     * Debug-Ausgabe am Ende der Seite
     */
    function fpcmDebugOutput() {
        if (!FPCM_DEBUG) {
            return false;
        }
        
        $html   = array();
        $html[] = 'Memory usage: '.round(memory_get_usage(true) / 1024 / 1024,2).'MB<br>';
        $html[] = 'Memorypeak: '.round(memory_get_peak_usage(true) / 1024 / 1024,2).'MB<br>';
        $html[] = 'BASEDIR: '.\fpcm\classes\baseconfig::$baseDir.'<br>';
        $html[] = 'PHPVERSION: '.PHP_VERSION;
        print '<p style="text-align:center;font-size:0.9em;margin-bottom:35px;">'.implode("\n", $html).'</p>'.PHP_EOL.PHP_EOL;
    }    
    
    /**
     * FanPress CM Dump Funktion
     * @param mixed $data
     */
    function fpcmDump($data) {
        print "<pre>";
        var_dump($data);
        print "</pre>";
    }    