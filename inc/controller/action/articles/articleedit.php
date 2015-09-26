<?php
    /**
     * Article edit controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articleedit extends articlebase {
        
        /**
         *
         * @var \fpcm\model\users\userList
         */
        protected $userList;
        
        /**
         *
         * @var \fpcm\model\comments\commentList
         */
        protected $commentList;  
        
        /**
         *
         * @var bool
         */
        protected $showRevision = false;
        
        /**
         *
         * @var bool
         */
        protected $pageTokenCheck;

        /**
         * @see \fpcm\controller\abstracts\controller::__construct()
         */        
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit');
            
            $this->view        = new \fpcm\model\view\acp('articleedit', 'articles');
            $this->userList    = new \fpcm\model\users\userList();
            $this->commentList = new \fpcm\model\comments\commentList();
        }

        /**
         * @see \fpcm\controller\abstracts\controller::request()
         * @return boolean
         */        
        public function request() {
            
            if (is_null($this->getRequestVar('articleid'))) {
                $this->redirect('articles/list');
            }
            
            $this->article = new \fpcm\model\articles\article($this->getRequestVar('articleid'));

            if (!$this->article->exists()) {
                $this->view->setNotFound('LOAD_FAILED_ARTICLE', 'articles/list');                
                return true;
            }
            
            if ($this->getRequestVar('revrestore')) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLEREVRESTORE');
            }
            
            $this->pageTokenCheck = $this->checkPageToken();
            if ($this->buttonClicked('doAction') && !$this->pageTokenCheck) {
                $this->view->addErrorMessage('CSRF_INVALID');
            }

            if ($this->buttonClicked('articleRevisionRestore') && ($this->getRequestVar('rev') || $this->getRequestVar('revisionIds')) && $this->pageTokenCheck) {
                
                $revisionIdsArray = !is_null($this->getRequestVar('revisionIds')) ? array_map('intval', $this->getRequestVar('revisionIds')) : false;
                
                $revisionId = !is_null($this->getRequestVar('rev'))
                            ? (int) $this->getRequestVar('rev')
                            : (is_array($revisionIdsArray) ? array_shift($revisionIdsArray) : false);
                
                if ($revisionId && $this->article->restoreRevision($revisionId)) {
                    $this->redirect('articles/edit&articleid='.$this->article->getId().'&revrestore=1');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_ARTICLEREVRESTORE');
                }
            }            
            
            if ($this->getRequestVar('rev') && $this->article->getRevision((int) $this->getRequestVar('rev'))) {
                $this->showRevision = true;
            }

            if ($this->buttonClicked('articleDelete') && !$this->showRevision && $this->pageTokenCheck) {
                if ($this->article->delete()) {
                    $this->redirect('articles/listall');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_ARTICLE');
                }
            }
            
            if ($this->buttonClicked('revisionDelete') && $this->getRequestVar('revisionIds') && !$this->showRevision && $this->pageTokenCheck) {
                if ($this->article->deleteRevisions($this->getRequestVar('revisionIds'))) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_REVISIONS');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_REVISIONS');
                }
            }            
            
            $res = false;
            
            $allTimer = time();
            
            if ($this->buttonClicked('articleSave') && !$this->showRevision && $this->pageTokenCheck) {
                $this->article->createRevision();
                
                $data = $this->getRequestVar('article', array(4,7));

                $this->article->setTitle($data['title']);
                $this->article->setContent($data['content']);
                
                $cats = $this->categoryList->getCategoriesCurrentUser();
                
                $categories = isset($data['categories']) ? array_map('intval', $data['categories']) : array(array_shift($cats)->getId());
                $this->article->setCategories($categories);

                if (isset($data['postponed']) && !isset($data['archived'])) {
                    $timer = strtotime($data['postponedate'].' '.(int) $data['postponehour'].':'.(int) $data['postponeminute'].':00');
                    
                    $postpone = 1;
                    if ($timer === false) {
                        $timer = $allTimer;
                        $postpone = 0;
                    }   
                    
                    $this->article->setPostponed($postpone);
                } else {
                    if ($this->article->getPostponed()) {
                        $this->article->setCreatetime($allTimer);
                    }
                    
                    $this->article->setPostponed(0);
                }
                
                $this->article->setPinned(isset($data['pinned']) ? 1 : 0);
                $this->article->setDraft(isset($data['draft']) ? 1 : 0);
                $this->article->setComments(isset($data['comments']) ? 1 : 0);
                $this->article->setApproval($this->permissions->check(array('article' => 'approve')) ? 1 : 0);

                if (isset($data['archived'])) {
                    $this->article->setArchived(1);
                    $this->article->setPinned(0);
                    $this->article->setDraft(0);
                } else {
                    $this->article->setArchived(0);
                }
                
                if (!$this->article->getTitle() || !$this->article->getContent()) {
                    $this->view->addErrorMessage('SAVE_FAILED_ARTICLE_EMPTY');
                    return true;
                }

                if (isset($data['author']) && trim($data['author'])) {
                    $this->article->setCreateuser($data['author']);
                }

                $this->article->setChangetime($allTimer);
                $this->article->setChangeuser($this->session->getUserId());                
                
                $this->article->prepareDataSave();
                
                $saved = true;
                $res   = $this->article->update();
            }
            
            $this->handleCommentActions();
            
            if ($res || $this->getRequestVar('added') == 1) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLE');
            } elseif ($this->getRequestVar('added') == 2) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLE_APPROVAL');
            } elseif (isset ($saved) && !$res) {
                $this->view->addErrorMessage('SAVE_FAILED_ARTICLE');                
            }
            
            return true;
            
        }
        
        /**
         * @see \fpcm\controller\abstracts\controller::process()
         * @return mixed
         */        
        public function process() {
            if (!parent::process()) return false;
            
            $this->article->prepareDataLoad();
            
            $this->view->assign('editorAction', 'articles/edit&articleid='.$this->article->getId());
            $this->view->assign('editorMode', 1);
            $this->view->assign('showRevisions', true);
            $this->view->assign('postponedTimer', $this->article->getCreatetime());
            $this->view->assign('users', $this->userList->getUsersByIds(array($this->article->getCreateuser(), $this->article->getChangeuser())));
            $this->view->assign('commentCount', array_sum($this->commentList->countComments(array($this->article->getId()))));
            $this->view->assign('comments', $this->commentList->getCommentsByCondition($this->article->getId(), -1, -1, -1));
            $this->view->assign('commentsMode', 2);
            
            $revisions = $this->article->getRevisions();
            $this->view->assign('revisions', $revisions);
            $this->view->assign('revisionCount', count($revisions));
            $this->view->assign('revisionPermission', $this->permissions->check(array('article' => 'revisions')));

            if ($this->showRevision) {
                $this->view->assign('isRevision', true);
                $this->view->assign('showRevisions', false);
                $this->view->assign('showComments', false);
                $this->view->assign('editorAction', 'articles/edit&articleid='.$this->article->getId().'&rev='.$this->getRequestVar('rev'));
            }
            
            $this->view->addJsVars(array(
                'fpcmEditorCommentLayerHeader' => $this->lang->translate('COMMENTS_EDIT'),
                'fpcmEditorCommentLayerSave'   => $this->lang->translate('GLOBAL_SAVE'),
                'fpcmCanConnect'               => \fpcm\classes\baseconfig::canConnect() ? 1 : 0
            ));
            
            if (!$this->permissions->check(array('article' => 'approve')) && $this->article->getApproval()) {
                $this->view->addMessage('Um den Artikel freizugeben, speichere ihn einfach erneut ab.');
            }
            
            $this->initPermissions();
            
            $this->view->render();
        }
        
        /**
         * Initialisiert Berechtigungen
         */
        protected function initPermissions() {
            $this->view->assign('showComments', $this->permissions->check(array('article' => array('editall', 'edit'), 'comment' => array('editall', 'edit'))));
            $this->view->assign('deleteCommentsPermissions', $this->permissions->check(array('comment' => 'delete')));
            $this->view->assign('permApprove', $this->permissions->check(array('comment' => 'approve')));
            $this->view->assign('permPrivate', $this->permissions->check(array('comment' => 'private')));            
            $this->view->assign('permEditOwn', $this->permissions->check(array('comment' => 'edit')));
            $this->view->assign('permEditAll', $this->permissions->check(array('comment' => 'editall')));
            $this->view->assign('currentUserId', $this->session->getUserId());
            $this->view->assign('isAdmin', $this->session->getCurrentUser()->isAdmin());
        }
        
        /**
         * Kommentar-Aktionen ausführen
         */
        protected function handleCommentActions() {

            if (!$this->pageTokenCheck) {
                return false;
            }
            
            if ($this->buttonClicked('deleteComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->commentList->deleteComments($ids)) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_COMMENTS');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_COMMENTS');
                }
            }  
            
            if ($this->buttonClicked('approveComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->commentList->toggleApprovement($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_APPROVEMENT');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_APPROVEMENT');
                }
            }
            
            if ($this->buttonClicked('privateComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->commentList->togglePrivate($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_PRIVATE');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_PRIVATE');
                }
            }
            
            if ($this->buttonClicked('spammerComments') && !is_null($this->getRequestVar('ids'))) {                
                $ids = $this->getRequestVar('ids');
                if ($this->commentList->toggleSpammer($ids)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_SPAMMER');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_SPAMMER');
                }
            }
        }
    }
?>