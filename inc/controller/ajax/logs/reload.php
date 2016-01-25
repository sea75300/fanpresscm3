<?php
    /**
     * AJAX logs reload controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\logs;
    
    /**
     * AJAX-Controller zum Reload der Systemloads
     * 
     * @package fpcm.controller.ajax.logs.relaod
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class reload extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * System-Logs-Typ
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
            
            call_user_func(array($this, 'loadLog'.$this->log));
            
            $this->events->runEvent('reloadSystemLogs');

        }
        
        /**
         * Lädt Sessions-Log (Typ 0)
         */
        private function loadLog0() {
            $userList = new \fpcm\model\users\userList();
            
            $view = new \fpcm\model\view\ajax('sessions', 'logs');
            $view->initAssigns();
            $view->assign('userList', $userList->getUsersAll());
            $view->assign('sessionList', $this->session->getSessions());
            $view->render();            
        }
        
        /**
         * Lädt System-Log (Typ 1)
         */
        private function loadLog1() {
            $view = new \fpcm\model\view\ajax('system', 'logs');
            $view->assign('systemLogs', array_map('json_decode', \fpcm\classes\logs::syslogRead()));
            $view->initAssigns();
            $view->render();            
        }
        
        /**
         * Lädt PHP-Error-Log (Typ 2)
         */        
        private function loadLog2() {
            $view = new \fpcm\model\view\ajax('errors', 'logs');
            $view->assign('errorLogs', array_map('json_decode', \fpcm\classes\logs::errorlogRead()));
            $view->initAssigns();
            $view->render();            
        }
        
        /**
         * Lädt Datenbank-Log (Typ 3)
         */
        private function loadLog3() {
            $view = new \fpcm\model\view\ajax('database', 'logs');
            $view->assign('databaseLogs', array_map('json_decode', \fpcm\classes\logs::sqllogRead()));
            $view->initAssigns();
            $view->render();             
        }
        
        /**
         * Lädt Cronjob-Log (Typ 4)
         */
        private function loadLog4() {
            $view = new \fpcm\model\view\ajax('packages', 'logs');
            $view->assign('packagesLogs', array_map('json_decode', \fpcm\classes\logs::pkglogRead()));
            $view->initAssigns();
            $view->render();   
        }
        
        /**
         * Lädt Cronjob-Log (Typ 5)
         */
        private function loadLog5() {
            $cronlist = new \fpcm\model\crons\cronlist();
            $view = new \fpcm\model\view\ajax('cronjobs', 'logs');
            $view->assign('cronjobList', $cronlist->getCronsData());
            $view->assign('currentTime', time());
            $view->initAssigns();
            $view->render();
        }

    }
?>
