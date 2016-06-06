<?php
    /**
     * Pofil controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class profile extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\common\timezone;
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         * Controller-Processing
         */
        public function __construct() {
            parent::__construct();
            $this->view = new \fpcm\model\view\acp('profile', 'system');
        }

        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            $author = $this->session->getCurrentUser();
            
            $pageTokenCheck = $this->checkPageToken();
            if ($this->buttonClicked('profileSave') && !$pageTokenCheck) {
                $this->view->addErrorMessage('CSRF_INVALID');
            }

            $this->view->assign('reloadSite', false);
            
            if ($this->buttonClicked('profileSave') && $pageTokenCheck) {
                $author->setEmail($this->getRequestVar('email'));
                $author->setDisplayName($this->getRequestVar('displayname'));
                
                $metaData = $this->getRequestVar('usermeta');
                $author->setUserMeta($metaData);

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
                        $this->view->addErrorMessage('SAVE_FAILED_USER_PROFILE');
                    }
                    elseif ($res === true) {
                        $reloadSite = ($metaData['system_lang'] != $this->config->system_lang ? true : false);
                        $this->view->assign('reloadSite', $reloadSite);
                        $this->view->addNoticeMessage('SAVE_SUCCESS_EDITUSER_PROFILE');
                    }
                    elseif ($res === \fpcm\model\users\author::AUTHOR_ERROR_PASSWORDINSECURE) {
                        $this->view->addErrorMessage('SAVE_FAILED_PASSWORD_SECURITY');
                    }
                    elseif ($res === \fpcm\model\users\author::AUTHOR_ERROR_NOEMAIL) {
                        $this->view->addErrorMessage('SAVE_FAILED_USER_PROFILEEMAIL');
                    }
                }                
            }
            
            $this->view->assign('author', $author);
            
            return true;
            
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
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
            $this->view->assign('inProfile', true);
            
            $this->view->addJsVars(array(
                'fpcmDtMasks' => \fpcm\classes\baseconfig::$dateTimeMasks
            ));
            
            $articleLimitList = array(
                10 => 10,
                25 => 25,
                50 => 50,
                75 => 75,
                100 => 100,
                125 => 125,
                150 => 150,
                200 => 200,
                250 => 250
            );
            $this->view->assign('articleLimitList', $articleLimitList);
            $this->view->assign('showDisableButton', false);
            $this->view->setViewJsFiles(array(\fpcm\classes\loader::libGetFileUrl('password-generator', 'password-generator.min.js')));
            
            $this->view->render();            
        }

    }
?>
