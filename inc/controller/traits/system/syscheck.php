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
                'helplink'  => 'http://php.net/'
            );

            $current = in_array('mysql', \PDO::getAvailableDrivers());
            $checkOptions['MySQL/MariaDB database driver']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/de/pdo.getavailabledrivers.php'
            );

            $current = (CRYPT_SHA256 == 1 ? true : false);
            $current = $current && in_array('sha256', hash_algos());            
            $checkOptions['sha256 hash algorithm']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/function.hash-algos.php'
            );
            
            $current = in_array('pdo', $loadedExtensions) && in_array('pdo_mysql', $loadedExtensions);
            $checkOptions['PHP Data Objects (PDO)']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.pdo.php'
            );
            
            $current = in_array('gd', $loadedExtensions);
            $checkOptions['GD Lib']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/book.image.php'
            );
            
            $current = in_array('json', $loadedExtensions);
            $checkOptions['JSON']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/book.json.php'
            );
            
            $current = in_array('xml', $loadedExtensions) && in_array('simplexml', $loadedExtensions) && class_exists('DOMDocument');
            $checkOptions['XML, SimpleXML, DOMDocument']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.simplexmlelement.php'
            );
            
            $current = in_array('zip', $loadedExtensions);
            $checkOptions['ZipArchive']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (true && $current),
                'helplink'  => 'http://php.net/manual/en/class.ziparchive.php'
            );
            
            $externalCon = \fpcm\classes\baseconfig::canConnect();
            $checkOptions['allow_url_fopen = 1 ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $externalCon ? 'true' : false,
                'recommend' => 'true',
                'result'    => (true && $externalCon),
                'helplink'  => 'http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen'
            );
            
            $current = in_array('curl', $loadedExtensions);
            $checkOptions['curl ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (false || $current),
                'helplink'  => 'http://php.net/manual/en/book.curl.php'
            );            
            
            $current = in_array('phar', $loadedExtensions);
            $checkOptions['Phar ('.$this->lang->translate('GLOBAL_OPTIONAL').')']    = array(
                'current'   => $current ? 'true' : 'false',
                'recommend' => 'true',
                'result'    => (false || $current),
                'helplink'  => 'http://php.net/manual/en/class.phar.php'
            );

            foreach ($this->getCheckFolders() as $description => $folderPath) {
                $current = is_writable($folderPath);
                
                $pathOutput = \fpcm\model\files\ops::removeBaseDir($folderPath, true);
                $checkOptions['<i>'.$pathOutput.'</i> '.$this->lang->translate('GLOBAL_WRITABLE')]    = array(
                    'current'   => $current ? 'true' : 'false',
                    'recommend' => 'true',
                    'result'    => (true && $current)
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