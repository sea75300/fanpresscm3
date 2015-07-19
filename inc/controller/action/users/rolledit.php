<?php
    /**
     * User roll add controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\users;
    
    class rolledit extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'users', 'system' => 'rolls');
            
            $this->view   = new \fpcm\model\view\acp('rolledit', 'users');
        }

        public function request() {
            if (is_null($this->getRequestVar('id'))) {
                $this->redirect('users/list');
            }           
            
            $userRoll = new \fpcm\model\users\userRoll($this->getRequestVar('id'));            
            
            if (!$userRoll->exists()) {
                $this->view->setNotFound('LOAD_FAILED_ROLL', 'users/list');                
                return true;
            }
            
            if ($this->buttonClicked('saveRoll')) {    
                $userRoll->setRollName($this->getRequestVar('rollname'));
                if ($userRoll->update()) {
                    $this->redirect ('users/list', array('edited' => 2));
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_ROLL');
                }            
            }
            
            $this->view->assign('userRoll', $userRoll);
            
            return true;
            
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $this->view->render();            
        }

    }
?>
