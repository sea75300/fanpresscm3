<?php
    /**
     * User edit controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\users;
    
    class useredit extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\common\timezone;
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'users');

            $this->view = new \fpcm\model\view\acp('useredit', 'users');
        }

        public function request() {
            
            if (is_null($this->getRequestVar('userid'))) {
                $this->redirect('users/list');
            }

            $author = new \fpcm\model\users\author($this->getRequestVar('userid'));            
            
            if (!$author->exists()) {
                $this->view->setNotFound('LOAD_FAILED_USER', 'users/list');                
                return true;
            }
                
            if ($this->buttonClicked('userSave') && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
            }
            
            if ($this->buttonClicked('userSave') && $this->checkPageToken()) {
                $author->setUserName($this->getRequestVar('username'));
                $author->setEmail($this->getRequestVar('email'));
                $author->setDisplayName($this->getRequestVar('displayname'));
                $author->setRoll($this->getRequestVar('roll'));
                $author->setUserMeta($this->getRequestVar('usermeta'));

                $newpass         = $this->getRequestVar('password');
                $newpass_confirm = $this->getRequestVar('password_confirm');

                $save = true;
                if ($newpass && $newpass_confirm) {
                    if (md5($newpass) == md5($newpass_confirm)) {
                        $author->setPassword($newpass);
                    } else {
                        $save = false;
                        $this->view->addErrorMessage('SAVE_FAILED_PASSWORD_MATCH');
                    }                    
                } else {
                    $author->disablePasswordSecCheck();
                }
                
                if ($save) {
                    $res = $author->update();

                    if ($res === false) {
                        $this->view->addErrorMessage('SAVE_FAILED_USER');
                    }
                    elseif ($res === true) {
                        $this->redirect ('users/list', array('edited' => 1));
                    }
                    elseif ($res === \fpcm\model\users\author::AUTHOR_ERROR_PASSWORDINSECURE) {
                        $this->view->addErrorMessage('SAVE_FAILED_PASSWORD_SECURITY');
                    }
                    elseif ($res === \fpcm\model\users\author::AUTHOR_ERROR_EXISTS) {
                        $this->view->addErrorMessage('SAVE_FAILED_USER_EXISTS');
                    }
                    elseif ($res === \fpcm\model\users\author::AUTHOR_ERROR_NOEMAIL) {
                        $this->view->addErrorMessage('SAVE_FAILED_USER_EMAIL');
                    }
                }                
            }
            
            $this->view->assign('author', $author);
            
            return true;
            
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $userRolls = new \fpcm\model\users\userRollList();            
            $this->view->assign('userRolls', $userRolls->getUserRollsTranslated());
            $this->view->assign('languages', array_flip($this->lang->getLanguages()));
                        
            $timezones = array();
            
            foreach ($this->getTimeZones() as $area => $zones) {
                foreach ($zones as $zone) {
                    $timezones[$area][$zone] = $zone;
                }
            }
            
            $this->view->assign('timezoneAreas', $timezones);
            $this->view->assign('externalSave', true);
            
            $this->view->render();            
        }

    }
?>
