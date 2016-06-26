<?php
    /**
     * Base AJAX controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
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
         * Rückgabe-Code
         * @var string
         */
        protected $returnCode;

        /**
         * Rückgabe-Daten
         * @var mixed
         */
        protected $returnData;

        /**
         * Update-Check de/aktivieren
         * @var bool
         */
        protected $updateCheckEnabled = false;
     
        /**
         * JSON-codiertes Array mit Rückgabe-Code und ggf. Rückgabe-Daten erzeugen
         * @return void
         * @since FPCM 3.2.0
         */
        protected function getResponse() {
            
            $data = array(
                'code' => $this->returnCode,
                'data' => $this->returnData
            );
            
            die(json_encode($data));
            
        }
        
    }
?>