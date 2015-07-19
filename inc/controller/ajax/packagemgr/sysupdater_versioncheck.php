<?php
    /**
     * AJAX system updates version check controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\packagemgr;
    
    /**
     * AJAX-Controller Paketmanager - Check von System-Version aus Updater
     * 
     * @package fpcm.controller.ajax.packagemgr.sysupdater_versioncheck
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    class sysupdater_versioncheck extends \fpcm\controller\abstracts\ajaxController {

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;
            
            die($this->config->system_version);
        }
    }
?>