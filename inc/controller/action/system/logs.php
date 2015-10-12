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
            $this->view->assign('errorLogs', array());
            $this->view->assign('systemLogs', array());
            $this->view->assign('databaseLogs', array());
            $this->view->assign('cronjobList', array());
            
            $this->view->render();
        }
        
    }
?>
