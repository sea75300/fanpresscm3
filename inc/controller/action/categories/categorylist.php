<?php
    /**
     * Category list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\categories;
    
    class categorylist extends \fpcm\controller\abstracts\controller {
        
        protected $view;

        protected $list;

        protected $rollList;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'categories');
            
            $this->view     = new \fpcm\model\view\acp('categorylist', 'categories');
            
            $this->list     = new \fpcm\model\categories\categoryList();
            $this->rollList = new \fpcm\model\users\userRollList();
        }

        public function request() {
            
            if ($this->getRequestVar('added')) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ADDCATEGORY');
            }
            
            if ($this->getRequestVar('edited')) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_EDITCATEGORY');
            }
            
            if ($this->buttonClicked('delete') && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }

            if ($this->buttonClicked('delete') && !is_null($this->getRequestVar('ids'))) {                
                $category = new \fpcm\model\categories\category($this->getRequestVar('ids'));
                
                if ($category->delete()) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_CATEGORIES');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_CATEGORIES');
                }
            }  
            
            return true;            
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $categoryList = $this->list->getCategoriesAll();
            
            foreach ($categoryList as &$category) {
                $rolls = $this->rollList->getRollsbyIdsTranslated(explode(';', $category->getGroups()));
                $category->setGroups(implode(', ', array_keys($rolls)));
            }
            
            $this->view->assign('categorieList', $categoryList);
            $this->view->setHelpLink('hl_options');
            
            $this->view->render();
        }

    }
?>
