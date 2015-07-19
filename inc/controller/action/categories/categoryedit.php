<?php
    /**
     * Category edit controller
     * @category Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\categories;
    
    class categoryedit extends \fpcm\controller\abstracts\controller {
        
        protected $view;

        protected $category;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'categories');
            
            $this->view = new \fpcm\model\view\acp('categoryedit', 'categories');
            
        }

        public function request() {
            if (is_null($this->getRequestVar('categoryid'))) {
                $this->redirect('categories/list');
            }
            
            $this->category = new \fpcm\model\categories\category($this->getRequestVar('categoryid'));
            
            if (!$this->category->exists()) {
                $this->view->setNotFound('LOAD_FAILED_CATEGORY', 'categories/list');
                return true;
            }            
            
            if ($this->buttonClicked('categorySave')) {
                $data = $this->getRequestVar('category');
                
                $groups = implode(';', array_map('intval', $data['groups']));
                $this->category->setGroups($groups);
                $this->category->setIconPath($data['iconpath']);
                $this->category->setName($data['name']);

                $res = $this->category->update();

                if ($res === false) $this->view->addErrorMessage('SAVE_FAILED_CATEGORY');
                if ($res === true) $this->redirect ('categories/list', array('edited' => 1));
            }
            
            return true;
            
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $userRolls = new \fpcm\model\users\userRollList();            
            $this->view->assign('userRolls', $userRolls->getUserRollsTranslated());               
            $this->view->assign('category', $this->category);
            $this->view->assign('selectedGroups', explode(';', $this->category->getGroups()));
            
            $this->view->render();            
        }

    }
?>