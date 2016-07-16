<?php
    /**
     * Permission edit controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class permissions extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var \fpcm\model\system\permissions
         */
        protected $permissionData;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'permissions');

            $this->view = new \fpcm\model\view\acp('permissions', 'system');
            
            $this->permissionData = new \fpcm\model\system\permissions();
        }

        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            $checkPageToken = $this->checkPageToken();
            if ($this->buttonClicked('permissionsSave') && !$checkPageToken) {
                $this->view->addErrorMessage('CSRF_INVALID');
            }
            
            if ($this->buttonClicked('permissionsSave') && !is_null($this->getRequestVar('permissions')) && $checkPageToken) {
                
                $permissionData = $this->getRequestVar('permissions');

                $res = false;
                foreach ($permissionData as $groupId => $permissions) {
                    $permissions = array_map(array($this, 'intval'), $permissions);
                    
                    if ($groupId == 1) {
                        $permissions['system']['permissions'] = 1;
                    }
                    
                    $permissions = array_replace_recursive($this->permissions->getPermissionSet(), $permissions);
                    $this->permissionData->setRollId($groupId);
                    $this->permissionData->setPermissionData($permissions);
                    if (!$this->permissionData->update()) {
                        $this->view->addErrorMessage('SAVE_FAILED_PERMISSIONS', array('{{rollid}}' => $groupId));
                    } else {
                        $res = true;
                    }
                }
                
                if ($res) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_PERMISSIONS');
                }
            }
            
            return true;
            
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;
            
            $userRolls = new \fpcm\model\users\userRollList();            
            $this->view->assign('userRolls', array_flip($userRolls->getUserRollsTranslated()));

            $this->view->assign('permissions', $this->permissionData->getPermissionsAll());            
            $this->view->assign('hideTitle', false);

            $this->view->setViewJsFiles(array(\fpcm\classes\baseconfig::$jsPath.'permissions.js'));
            
            $this->view->render();            
        }
        
        /**
         * Intval auf alle Array-Elemente anwenden
         * @param array $data
         * @return array
         */
        private function intval($data) {
            return array_map('intval', $data);
        }

    }
?>
