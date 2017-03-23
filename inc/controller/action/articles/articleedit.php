<?php
    /**
     * Article edit controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articleedit extends articlebase {
        
        use \fpcm\controller\traits\comments\lists,
            \fpcm\model\articles\permissions;
        
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
        protected $checkPageToken = true;
        
        /**
         *
         * @var \fpcm\model\articles\article
         */
        protected $revisionArticle = null;
        
        /**
         *
         * @var int
         */
        protected $revisionId = 0;

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

            $this->checkEditPermissions($this->article);
            if (!$this->article->getEditPermission()) {
                $this->view = new \fpcm\model\view\error();
                $this->view->setMessage($this->lang->translate('PERMISSIONS_REQUIRED'));
                $this->view->render();
                return false;
            }

            if ($this->getRequestVar('revrestore')) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLEREVRESTORE');
            }
            
            $this->checkPageToken = $this->checkPageToken();
            if ($this->buttonClicked('doAction') && !$this->checkPageToken) {
                $this->view->addErrorMessage('CSRF_INVALID');
            }
            
            $revisionIdsArray   = !is_null($this->getRequestVar('revisionIds'))
                                ? array_map('intval', $this->getRequestVar('revisionIds'))
                                : false;
            
            if ($this->buttonClicked('revisionDelete') && $revisionIdsArray && !$this->showRevision && $this->checkPageToken) {
                if ($this->article->deleteRevisions($revisionIdsArray)) {
                    $this->view->addNoticeMessage('DELETE_SUCCESS_REVISIONS');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_REVISIONS');
                }
            }
            
            $this->revisionId   = !is_null($this->getRequestVar('rev'))
                                ? (int) $this->getRequestVar('rev')
                                : (is_array($revisionIdsArray) ? array_shift($revisionIdsArray) : false);
            
            if ($this->buttonClicked('articleRevisionRestore') && ($this->getRequestVar('rev') || $this->getRequestVar('revisionIds')) && $this->checkPageToken) {
                if ($this->revisionId && $this->article->restoreRevision($this->revisionId)) {
                    $this->redirect('articles/edit&articleid='.$this->article->getId().'&revrestore=1');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_ARTICLEREVRESTORE');
                }
            }            
            
            if ($this->revisionId) {
                
                
                include_once \fpcm\classes\loader::libGetFilePath('PHP-FineDiff', 'finediff.php');
                
                $this->revisionArticle = clone $this->article;
                
                if (!$this->revisionId) {
                    $this->revisionId = (int) $this->getRequestVar('rev');
                }                

                $this->showRevision   = ($this->revisionArticle->getRevision($this->revisionId) ? true : false);
                
                $from = $this->revisionArticle->getContent();
                $opcode = \FineDiff::getDiffOpcodes($from, $this->article->getContent(), \FineDiff::$characterGranularity);
                $this->view->assign('textDiff', \FineDiff::renderDiffToHTMLFromOpcodes($from, $opcode));

            }

            if ($this->buttonClicked('articleDelete') && !$this->showRevision && $this->checkPageToken) {
                if ($this->article->delete()) {
                    $this->redirect('articles/listall');
                } else {
                    $this->view->addErrorMessage('DELETE_FAILED_ARTICLE');
                }
            }
            
            $res = false;
            
            $allTimer = time();
            
            if ($this->buttonClicked('articleSave') && !$this->showRevision && $this->checkPageToken) {

                $this->article->prepareRevision();
                
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
                    $this->article->setCreatetime($timer);
                } else {
                    if ($this->article->getPostponed() || ($this->article->getDraft() && !isset($data['draft']))) {
                        $this->article->setCreatetime($allTimer);
                    }
                    
                    $this->article->setPostponed(0);
                }
                
                $this->article->setPinned(isset($data['pinned']) ? 1 : 0);
                $this->article->setDraft(isset($data['draft']) ? 1 : 0);
                $this->article->setComments(isset($data['comments']) ? 1 : 0);
                $this->article->setApproval($this->permissions->check(array('article' => 'approve')) ? 1 : 0);
                $this->article->setImagepath(isset($data['imagepath']) ? $data['imagepath'] : '');
                $this->article->setSources(isset($data['sources']) ? $data['sources'] : '');

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

                if (isset($data['tweettxt']) && $data['tweettxt']) {
                    $this->article->setTweetOverride($data['tweettxt']);
                }

                $this->article->setChangetime($allTimer);
                $this->article->setChangeuser($this->session->getUserId());
                $this->article->setMd5path($this->article->getArticleNicePath());

                $this->article->prepareDataSave();
                
                $saved = true;
                $res   = $this->article->update();
                
                if ($res) {
                    $this->article->createRevision();
                }
            }
            
            $this->handleCommentActions();
            
            if ($res || $this->getRequestVar('added') == 1) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLE');
            } elseif ($this->getRequestVar('added') == 2) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_ARTICLE_APPROVAL');
            } elseif (isset ($saved) && !$res) {
                $this->view->addErrorMessage('SAVE_FAILED_ARTICLE');                
            }

            if (!$this->revisionId) {
                $this->article->prepareDataLoad();
            }
            
            return true;
            
        }
        
        /**
         * @see \fpcm\controller\abstracts\controller::process()
         * @return mixed
         */        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('editorAction', 'articles/edit&articleid='.$this->article->getId());
            $this->view->assign('editorMode', 1);
            $this->view->assign('showRevisions', true);
            $this->view->assign('postponedTimer', $this->article->getCreatetime());
            $this->view->assign('users', $this->userList->getUsersByIds(array($this->article->getCreateuser(), $this->article->getChangeuser())));
            $this->view->assign('commentCount', array_sum($this->commentList->countComments(array($this->article->getId()))));
            
            $search = new \fpcm\model\comments\search();
            $search->articleid  = $this->article->getId();
            $search->searchtype = 0;

            $this->view->assign('comments', $this->commentList->getCommentsBySearchCondition($search));
            $this->view->assign('commentsMode', 2);
            
            $revisions = $this->article->getRevisions();
            $this->view->assign('revisions', $revisions);
            $this->view->assign('revisionCount', count($revisions));
            $this->view->assign('revisionPermission', $this->permissions->check(array('article' => 'revisions')));
            
            $this->view->addJsVars([
                'fpcmEditorCommentLayerSave'   => $this->lang->translate('GLOBAL_SAVE'),
                'fpcmCanConnect'               => \fpcm\classes\baseconfig::canConnect() ? 1 : 0,
                'fpcmNavigationActiveItemId'   => 'itemnav-id-editnews',
                'fpcmArticleId'                => $this->article->getId(),
                'fpcmCheckTimeout'             => FPCM_ARTICLE_LOCKED_INTERVAL * 1000,
                'fpcmCheckLastState'           => -1
            ]);
            
            $this->view->addJsLangVars([
                'editor_status_inedit'    => $this->lang->translate('EDITOR_STATUS_INEDIT'),
                'editor_status_notinedit' => $this->lang->translate('EDITOR_STATUS_NOTINEDIT'),
            ]);
            
            $this->view->addJsLangVars(['editorCommentLayerHeader' => $this->lang->translate('COMMENTS_EDIT')]);
            
            if (!$this->permissions->check(array('article' => 'approve')) && $this->article->getApproval()) {
                $this->view->addMessage('SAVE_SUCCESS_APPROVAL_SAVE');
            }

            if ($this->article->isInEdit()) {
                $this->view->addMessage('EDITOR_STATUS_INEDIT');
            }
            
            $this->initPermissions();

            $this->view->assign('isRevision', false);
            if ($this->showRevision) {
                $this->view->assign('revisionArticle', $this->revisionArticle);
                $this->view->assign('editorFile', \fpcm\classes\baseconfig::$viewsDir.'articles/editors/revisiondiff.php');
                $this->view->assign('isRevision', true);
                $this->view->assign('showRevisions', false);
                $this->view->assign('showComments', false);
                $this->view->assign('editorAction', 'articles/edit&articleid='.$this->article->getId().'&rev='.$this->getRequestVar('rev'));
            }
            
            $this->view->render();
        }
        
        /**
         * Initialisiert Berechtigungen
         */
        protected function initPermissions() {
            $this->view->assign('showComments', $this->permissions->check(array('article' => array('editall', 'edit'), 'comment' => array('editall', 'edit'))));
            $this->view->assign('permDeleteArticle', $this->permissions->check(array('article' => 'delete')));
            $this->view->assign('deleteCommentsPermissions', $this->permissions->check(array('comment' => 'delete')));
            $this->view->assign('permApprove', $this->permissions->check(array('comment' => 'approve')));
            $this->view->assign('permPrivate', $this->permissions->check(array('comment' => 'private')));            
            $this->view->assign('permEditOwn', $this->permissions->check(array('comment' => 'edit')));
            $this->view->assign('permEditAll', $this->permissions->check(array('comment' => 'editall')));
            $this->view->assign('currentUserId', $this->session->getUserId());
            $this->view->assign('isAdmin', $this->session->getCurrentUser()->isAdmin());

            $this->initCommentPermissions();
            
        }
        
        /**
         * Kommentar-Aktionen ausführen
         */
        protected function handleCommentActions() {

            if (!$this->checkPageToken || !$this->buttonClicked('DoAction')) {
                return false;
            }

            $this->processCommentActions($this->commentList);

        }
    }
?>
