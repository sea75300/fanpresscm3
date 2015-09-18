<?php
    /**
     * Package object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\packages;

    /**
     * Update package objekt
     * 
     * @package fpcm.model.packages
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.1
     */
    class update extends package {
 
        /**
         * Konstruktor
         * @param string $key Package-Key
         * @param string $version Package-Version
         * @param string $type Package-Type
         * @param string $signature Package-Signature
         */
        public function __construct($type, $key, $version = '', $signature = '') {            
            parent::__construct('update', $key, $version, $signature);
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
            
            $res = true;
            foreach ($this->files as $zipFile) {
                $source = $this->extractPath.$zipFile;

                $dest   = dirname(\fpcm\classes\baseconfig::$baseDir.$this->copyDestination.$zipFile);
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

    }
