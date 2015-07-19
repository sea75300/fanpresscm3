<?php
    /**
     * Comment list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\comments;
    
    class commentlist extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var \fpcm\model\comments\commentList
         */
        protected $list;

        /**
         *
         * @var \fpcm\model\articles\articlelist
         */
        protected $articleList;

        /**
         * @see \fpcm\controller\abstracts\controller::__construct()
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => array('editall', 'edit'), 'comment' => array('editall', 'edit'));
            
            $this->view         = new \fpcm\model\view\acp('commentlist', 'comments');            
            $this->list         = new \fpcm\model\comments\commentList();
            $this->articleList  = new \fpcm\model\articles\articlelist();
        }

        /**
         * @see \fpcm\controller\abstracts\controller::request()
         * @return boolean
         */
        public function request() {        

            if ($this->buttonClicked('deleteComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->list->deleteComments($ids)) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_COMMENTS');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_COMMENTS');
                }
            }  
            
            if ($this->buttonClicked('approveComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->list->toggleApprovement($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_APPROVEMENT');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_APPROVEMENT');
                }
            }
            
            if ($this->buttonClicked('privateComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->list->togglePrivate($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_PRIVATE');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_PRIVATE');
                }
            }
            
            if ($this->buttonClicked('spammerComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->list->toggleSpammer($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_SPAMMER');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_SPAMMER');
                }
            }
            
            return true;            
        }
        
        /**
         * @see \fpcm\controller\abstracts\controller::process()
         * @return mixed
         */        
        public function process() {
            if (!parent::process()) return false;

            $this->initPermissions();

            $this->view->assign('ownArticleIds', $this->articleList->getArticleIDsByUser($this->session->getUserId()));
            $this->view->assign('comments', $this->list->getCommentsAll());
            $this->view->assign('commentsMode', 1);
            $this->view->render();
        }
        
        /**
         * Initialisiert Berechtigungen
         */
        protected function initPermissions() {
            if (!$this->permissions) return false;
            
            $this->view->assign('deleteCommentsPermissions', $this->permissions->check(array('comment' => 'delete')));            
            $this->view->assign('permApprove', $this->permissions->check(array('comment' => 'approve')));
            $this->view->assign('permPrivate', $this->permissions->check(array('comment' => 'private')));
            $this->view->assign('permEditOwn', $this->permissions->check(array('comment' => 'edit')));
            $this->view->assign('permEditAll', $this->permissions->check(array('comment' => 'editall')));
            $this->view->assign('isAdmin', $this->session->getCurrentUser()->isAdmin());
        }

    }
?>