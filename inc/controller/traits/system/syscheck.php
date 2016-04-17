<?php
    /**
     * System check trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\system;
    
    /**
     * System check trait
     * 
     * @package fpcm.controller.traits.system.syscheck
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    trait syscheck {
        
        /**
         * System-Check ausführen
         * @return array
         */
        protected function getCheckOptionsSystem() {
            $checkOptions     = array();
            
            $loadedExtensions = array_map('strtolower', get_loaded_extensions());            
            
            $phpVer = '5.4.0';
            $checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_PHPVERSION')]    = array(
                'current'   => phpversion(),
                'recommend' => $phpVer,
                'result'    => version_compare(phpversion(), $phpVer, '>='),
                'helplink'  => 'http://php.net/',
                'optional'  => 0
            );
            
            $recomVal = 64;
            $curVal   = substr(ini_get('memory_limit'), 0, -1);
            $checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_PHPMEMLIMIT')]    = array(
                'current'   => $curVal.' MiB',  
                'recommend' => $recomVal.' MiB',
                'result'    => ($curVal >= $recomVal ? true : false),
                'helplink'  => 'http://php.net/manual/de/info.configuration.php',
                'optional'  => 1
            );
            
            $recomVal = 10;
            $curVal   = ini_get('max_execution_time');
            $checkOptions[$this->lang->translate('SYSTEM_OPTIONS_SYSCHECK_PHPMAXEXECTIME')]    = array(
                'current'   => $curVal.' sec',
                'recommend' => $recomVal.' sec',
                'result'    => ($curVal >= $recomVal ? true : false),
                'helplink'  => 'http://php.net/manual/de/info.configuration.php',
                'optional'  => 1
            );

            $dbDrivers   = \PDO::getAvailableDrivers();
            $resultMySql = in_array('mysql', $dbDrivers);
            $resultPgSql = in_array('pgsql', $dbDrivers);
            $sqlhelp     = 'http://php.net/manual/de/pdo.getavailabledrivers.php';

            $current = $resultMySql || $resultPgSql ? true : false;
            
            $checkOptions['MySQL/MariaDB Database Driver']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => $resultMySql,
                'helplink'  => $sqlhelp,
                'optional'  => (!$resultMySql && $resultPgSql ? 1 : 0)
            );
            
            $checkOptions['Postgres Database Driver']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => $resultPgSql,
                'helplink'  => $sqlhelp,
                'optional'  => ($resultMySql ? 1 : 0)
            );

            $current = (CRYPT_SHA256 == 1 ? true : false);
            $current = $current && in_array('sha256', hash_algos());            
            $checkOptions['SHA256 Hash Algorithm']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/function.hash-algos.php',
                'optional'  => 0
            );
            
            $current = in_array('pdo', $loadedExtensions) && in_array('pdo_mysql', $loadedExtensions);
            $checkOptions['PHP Data Objects (PDO)']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.pdo.php',
                'optional'  => 0
            );
            
            $current = in_array('gd', $loadedExtensions);
            $checkOptions['GD Lib']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/book.image.php',
                'optional'  => 0
            );
            
            $current = in_array('json', $loadedExtensions);
            $checkOptions['JSON']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/book.json.php',
                'optional'  => 0
            );
            
            $current = in_array('xml', $loadedExtensions) && in_array('simplexml', $loadedExtensions) && class_exists('DOMDocument');
            $checkOptions['XML, SimpleXML, DOMDocument']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.simplexmlelement.php',
                'optional'  => 0
            );
            
            $current = in_array('zip', $loadedExtensions);
            $checkOptions['ZipArchive']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.ziparchive.php',
                'optional'  => 0
            );
            
            $externalCon = \fpcm\classes\baseconfig::canConnect();
            $checkOptions['allow_url_fopen = 1 ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $externalCon ? 'true' : false,
                'recommend' => 'true',
                'result'    => (true && $externalCon),
                'helplink'  => 'http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen',
                'optional'  => 1
            );
            
            $current = in_array('curl', $loadedExtensions);
            $checkOptions['cURL ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (false || $current),
                'helplink'  => 'http://php.net/manual/en/book.curl.php',
                'optional'  => 1
            );            
            
            $current = in_array('phar', $loadedExtensions);
            $checkOptions['Phar ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (false || $current),
                'helplink'  => 'http://php.net/manual/en/class.phar.php',
                'optional'  => 1
            );

            $checkFolders = $this->getCheckFolders();
            foreach ($checkFolders as $description => $folderPath) {
                $current = is_writable($folderPath);
                
                $pathOutput = \fpcm\model\files\ops::removeBaseDir($folderPath, true);
                $checkOptions['<i>'.$pathOutput.'</i> '.$this->lang->translate('GLOBAL_WRITABLE')]    = array(
                    'current'   => $current ? 'true' : 'false',
                    'recommend' => 'true',
                    'result'    => (true && $current),
                    'optional'  => 0
                );                
            }
            
            return $checkOptions;
        }
        
        public function getCheckFolders() {
            $checkFolders = array(
                \fpcm\classes\baseconfig::$dataDir,
                \fpcm\classes\baseconfig::$cacheDir,
                \fpcm\classes\baseconfig::$configDir,
                \fpcm\classes\baseconfig::$filemanagerTempDir,
                \fpcm\classes\baseconfig::$logDir,
                \fpcm\classes\baseconfig::$moduleDir,
                \fpcm\classes\baseconfig::$revisionDir,
                \fpcm\classes\baseconfig::$smileyDir,
                \fpcm\classes\baseconfig::$uploadDir,
                \fpcm\classes\baseconfig::$stylesDir,
                \fpcm\classes\baseconfig::$tempDir,
                \fpcm\classes\baseconfig::$shareDir,
                \fpcm\classes\baseconfig::$dbdumpDir
            );
            
            natsort($checkFolders);
            
            return $checkFolders;
        }
        
    }
?>