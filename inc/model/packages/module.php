<?php
    /**
     * Package object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\packages;

    /**
     * System package objekt
     * 
     * @package fpcm.model.packages
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.1
     */
    class module extends package {

        /**
         * Konstruktor
         * @param string $key Package-Key
         * @param string $version Package-Version
         * @param string $type Package-Type
         * @param string $signature Package-Signature
         */
        public function __construct($type, $key, $version = '', $signature = '') {
            parent::__construct('module', $key, $version, $signature);
        }

        /**
         * Kopiert Inhalt von Paket von Quelle nach Ziel
         * @return boolean
         */
        public function copy() {    
            
            if (!file_exists($this->tempListFile)) {
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }
            
            $this->loadPackageFileListFromTemp();
            
            if (!count($this->files)) {
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }
            
            $vendorFolder = \fpcm\classes\baseconfig::$baseDir.$this->copyDestination.dirname($this->key);
            if (!is_dir($vendorFolder) && !mkdir($vendorFolder) ) {
                trigger_error('Unable to create module vendor folder '.\fpcm\model\files\ops::removeBaseDir($vendorFolder, true));
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }

            $res = true;
            foreach ($this->files as $zipFile) {
                $source = $this->extractPath.$zipFile;

                $dest   = \fpcm\classes\baseconfig::$baseDir.$this->copyDestination.str_replace(basename($this->key).'/', $this->key.'/', $zipFile);
                $dest   = $this->replaceFanpressDirString($dest);
                
                if (is_dir($source)) {
                    if (!file_exists($dest) && !mkdir($dest, 0777)) {
                        if (!is_array($res)) $res = array();
                        $res[] = $dest;
                    }
                    continue;
                }
                
                if (file_exists($dest) && sha1_file($source) == sha1_file($dest)) {
                    continue;
                }
                
                if (!copy($source, $dest)) {
                    if (!is_array($res)) $res = array();                    
                    $res[] = $dest;
                }
                
            }            
            
            return is_array($res) ? self::FPCMPACKAGE_FILESCOPY_ERROR : $res;
        }

        /**
         * Initialisiert Daten
         */
        protected function init() {
            $this->filename     = $this->key.'_version'.$this->version.'.zip';

            $this->remoteFile   = \fpcm\classes\baseconfig::$moduleServer.self::FPCMPACKAGE_SERVER_PACKAGEPATH.$this->filename;
            $this->localFile    = \fpcm\classes\baseconfig::$tempDir.$this->filename;            
            $this->extractPath  = \fpcm\classes\baseconfig::$tempDir.dirname($this->key).'/';
            $this->tempListFile = \fpcm\classes\baseconfig::$tempDir.md5($this->localFile);
            
            $copyDest = str_replace(\fpcm\classes\baseconfig::$baseDir, '', \fpcm\classes\baseconfig::$moduleDir);
            $this->setCopyDestination($copyDest);
        }

    }
