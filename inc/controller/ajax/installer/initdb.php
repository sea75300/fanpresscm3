<?php
    /**
     * AJAX installer database init controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\installer;
    
    /**
     * AJAX-Controller zur Initialisierung der Datenbank im Installer
     * 
     * @package fpcm.controller.ajax.installer.initdb
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class initdb extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Datenbank-Config-Datei
         * @var string
         */
        protected $filename;

        /**
         * Konstruktor
         * @return boolean
         */
        public function __construct() {
            return true;
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            if (!\fpcm\classes\baseconfig::dbConfigExists() && !\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            $this->filename = base64_decode(str_rot13(base64_decode($this->getRequestVar('file'))));
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {            

            if (!file_exists($this->filename) || strpos($this->filename, '.sql') === false) die('0');
            
            $db = new \fpcm\classes\database(false, true);
            
            $sql = str_replace('{{dbpref}}', $db->getDbprefix(), file_get_contents($this->filename));            
            if($db->exec($sql)) die('1');            
            die('0');
        }

    }
?>