<?php
    /**
     * Login controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\users;
    
    class userlist extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var \fpcm\model\users\userList
         */
        protected $userList;
        
        /**
         *
         * @var \fpcm\model\users\userRollList
         */
        protected $rollList;

        /**
         *
         * @var \fpcm\model\articles\articlelist
         */
        protected $articleList;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'users');
            
            $this->view = new \fpcm\model\view\acp('userlist', 'users');
            
            $this->userList     = new \fpcm\model\users\userList(); 
            $this->rollList     = new \fpcm\model\users\userRollList();
            $this->articleList  = new \fpcm\model\articles\articlelist();
        }

        public function request() {
            
            if ($this->getRequestVar('added') == 1) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ADDUSER');
            } elseif ($this->getRequestVar('added') == 2) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ADDROLL');
            }
            
            if ($this->getRequestVar('edited') == 1) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_EDITUSER');
            } elseif ($this->getRequestVar('edited') == 2) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_EDITROLL');
            }

            if ( ($this->buttonClicked('disableUser') ||
                  $this->buttonClicked('enableUser') ||
                  $this->buttonClicked('deleteActive') ||
                  $this->buttonClicked('deleteDisabled') ||
                  $this->buttonClicked('deleteRoll') ) && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }
            
            if ($this->buttonClicked('disableUser') && !is_null($this->getRequestVar('useridsa'))) {
                $this->disableUsers($this->getRequestVar('useridsa'));
            }
            
            if ($this->buttonClicked('enableUser') && !is_null($this->getRequestVar('useridsd'))) {
                $this->enableUsers($this->getRequestVar('useridsd'));
            }
            
            if ($this->buttonClicked('deleteActive') && !is_null($this->getRequestVar('useridsa'))) {
                $this->deleteUsers($this->getRequestVar('useridsa'));
            }
            
            if ($this->buttonClicked('deleteDisabled') && !is_null($this->getRequestVar('useridsd'))) {
                $this->deleteUsers($this->getRequestVar('useridsd'), false);
            }
            
            if ($this->buttonClicked('deleteRoll') && !is_null($this->getRequestVar('rollids'))) {
                $roll = new \fpcm\model\users\userRoll($this->getRequestVar('rollids'));
                
                if ($roll->delete()) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_ROLL');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_ROLL');
                }
            }  
            
            return true;            
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $translatedRolls = $this->rollList->getUserRollsTranslated();
            
            $this->view->assign('currentUser', $this->session->getUserId());
            $this->view->assign('usersActive', $this->userList->getUsersActive(true));
            $this->view->assign('usersDisabled', $this->userList->getUsersDisabled(true));
            $this->view->assign('usersRollList', $translatedRolls);
            $this->view->assign('usersRolls', array_flip($translatedRolls));
            $this->view->assign('articleCounts', $this->articleList->countArticlesByUsers());
            
            $this->view->assign('rollPermissions', $this->permissions->check(array('system' => 'rolls')));

            $this->view->render();
        }
        
        /**
         * Benutzer deaktivieren
         * @param array $userId
         * @return void
         */
        private function disableUsers($userId) {
            if ($this->userList->countActiveUsers() == 1) {
                $this->view->addErrorMessage('SAVE_FAILED_USER_DISABLE_LAST');
                return;
            }                

            if ($userId == $this->session->getUserId()) {
                $this->view->addErrorMessage('SAVE_FAILED_USER_DISABLE_OWN');
                return;
            }

            $user = new \fpcm\model\users\author($userId);
            if ($user->disable()) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_USER_DISABLE');
            } else {
                $this->view->addErrorMessage('SAVE_FAILED_USER_DISABLE');
            }
        }
        
        /**
         * Benutzer aktivieren
         * @param array $userId
         * @return void
         */
        private function enableUsers($userId) {
            if ($userId == $this->session->getUserId()) {
                return;
            }

            $user = new \fpcm\model\users\author($userId);
            if ($user->enable()) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_USER_ENABLE');
            } else{
                $this->view->addErrorMessage('SAVE_FAILED_USER_ENABLE');
            }
        }
        
        /**
         * Benutzer löschen
         * @param array $userId
         * @param bool $check
         * @return void
         */
        private function deleteUsers($userId, $check = true) {
            if ($check && $this->userList->countActiveUsers() == 1) {
                $this->view->addErrorMessage('DELETE_FAILED_USERS_LAST');
                return;                    
            }                

            if ($check && $userId == $this->session->getUserId()) {
                $this->view->addErrorMessage('DELETE_FAILED_USERS_OWN');
                return;
            }

            $user = new \fpcm\model\users\author($userId);
            if ($user->delete()) {
                $this->view->addNoticeMessage('DELETE_SUCCESS_USERS');
            } else {
                $this->view->addErrorMessage('DELETE_FAILED_USERS');
            }
        }

    }
?>
