<?php

    namespace fpcm\model\files;

    /**
     * Article template file list
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.files
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.3.0
     */    
    final class templatefilelist extends \fpcm\model\abstracts\filelist {

        /**
         * Erlaubte Dateierweiterungen
         * @var array
         */
        public static $allowedExts  = array('html', 'htm');

        /**
         * Erlaubte Dateitypen
         * @var array
         */
        public static $allowedTypes = array('application/xhtml+xml', 'text/html');


        /**
         * Konstruktor
         */
        public function __construct() {
            $this->basepath = \fpcm\classes\baseconfig::$articleTemplatesDir;
            $this->exts     = static::$allowedExts;
            parent::__construct();
        }
        
        /**
         * Gibt aktuelle Größe des upload-Ordners in byte zurück
         * @return int
         */
        public function getUploadFolderSize() {     
            return array_sum(array_map('filesize', $this->getFolderList()));
        }


        /**
         * Gibt Liste von Dateien mit den erlaubten Dateierweiterungen zurück
         * @return array
         */
        public function getFolderList() {            

            $files = parent::getFolderList();
            
            $idxkey = array_search(\fpcm\classes\baseconfig::$articleTemplatesDir.'index.html', $files);
            unset($files[$idxkey]);

            return $files;
        }
        
    }
?>