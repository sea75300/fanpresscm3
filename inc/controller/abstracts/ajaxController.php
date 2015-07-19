<?php
    /**
     * Base AJAX controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\abstracts;

    /**
     * Basis für AJAX-Controller
     * 
     * @package fpcm.controller.abstracts.ajaxController
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @abstract
     */
    class ajaxController extends controller {

        /**
         * Update-Check de/aktivieren
         * @var bool
         */
        protected $updateCheckEnabled = false;
        
    }
?>