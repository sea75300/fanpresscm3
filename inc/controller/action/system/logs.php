<?php
    /**
     * Log view controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class logs extends \fpcm\controller\abstracts\controller {
        
        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'options');

            $this->view   = new \fpcm\model\view\acp('overview', 'logs');
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            $userList = new \fpcm\model\users\userList();

            $this->view->assign('userList', $userList->getUsersAll());            
            $this->view->assign('sessionList', $this->session->getSessions());
            $this->view->assign('errorLogs', array_map('json_decode', \fpcm\classes\logs::errorlogRead()));
            $this->view->assign('systemLogs', array_map('json_decode', \fpcm\classes\logs::syslogRead()));
            $this->view->assign('databaseLogs', array_map('json_decode', \fpcm\classes\logs::sqllogRead()));

            $cronlist = new \fpcm\model\crons\cronlist();
            $this->view->assign('cronjobList', $cronlist->getCronsData());
            $this->view->assign('currentTime', time());
            
            $this->view->render();
        }
        
    }
?>
