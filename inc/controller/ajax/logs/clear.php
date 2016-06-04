<?php
    /**
     * AJAX logs clear controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\logs;
    
    /**
     * AJAX-Controller zum leeren der Systemlogs
     * 
     * @package fpcm.controller.ajax.logs.clear
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class clear extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * System-Log-Typ
         * @var int
         */
        protected $log;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            
            if (!$this->permissions->check(array('system' => 'logs'))) {
                return false;
            }
            
            if (is_null($this->getRequestVar('log'))) return false;
            
            $this->log = (int) $this->getRequestVar('log');
            
            return true;
        }
        
        /**
         * Controller-Processing
         */ 
        public function process() {
            
            if (!parent::process()) return false;
            
            $res = \fpcm\classes\logs::clearLog($this->log);
            
            $this->events->runEvent('clearSystemLogs');
            
            $view = new \fpcm\model\view\ajax();
            if ($res) {
                $view->addNoticeMessage('LOGS_CLEARED_LOG_OK');
            } else {
                $view->addErrorMessage('LOGS_CLEARED_LOG_FAILED');
            }
            $view->render();
            
        }

    }
?>
