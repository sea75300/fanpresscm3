<?php
    /**
     * Article list controller base
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistbase extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\articles\lists;
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;
        
        /**
         *
         * @var \fpcm\model\categories\categoryList
         */
        protected $categoryList;
        
        /**
         *
         * @var \fpcm\model\users\userList
         */
        protected $userList;
        
        /**
         *
         * @var \fpcm\model\articles\articlelist
         */
        protected $articleList;
        
        /**
         *
         * @var \fpcm\model\comments\commentList
         */
        protected $commentList;
        
        /**
         * Liste mit erlaubten Artikel-Aktionen
         * @var array
         */
        protected $articleActions = array();

        /**
         *
         * @var array
         */
        protected $articleItems = array();
        
        /**
         *
         * @var bool
         */
        protected $deleteActions = false;
        
        /**
         *
         * @var int
         */
        protected $listShowLimit = \FPCM_ACP_ARTICLELIST_LIMIT;
        
        /**
         *
         * @var int
         */
        protected $listShowStart = 0;
        
        /**
         *
         * @var int
         */
        protected $articleCount = 0;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->articleList      = new \fpcm\model\articles\articlelist();
            $this->categoryList     = new \fpcm\model\categories\categoryList();
            $this->commentList      = new \fpcm\model\comments\commentList();
            $this->userList         = new \fpcm\model\users\userList();

            $this->listShowLimit    = $this->config->articles_acp_limit;

            $this->view             = new \fpcm\model\view\acp('listouter', 'articles');
            
            $this->articleActions   = array(
                $this->lang->translate('ARTICLE_LIST_PINNED')         => 'pinn',
                $this->lang->translate('ARTICLE_LIST_APPROVE')        => 'approval',
                $this->lang->translate('EDITOR_ARCHIVE')              => 'archive',
                $this->lang->translate('ARTICLE_LIST_COMMENTS')       => 'comments',
                $this->lang->translate('ARTICLE_LIST_NEWTWEET')       => 'newtweet',
                $this->lang->translate('GLOBAL_DELETE')               => 'delete',
                $this->lang->translate('ARTICLE_LIST_RESTOREARTICLE') => 'restore',
                $this->lang->translate('ARTICLE_LIST_EMPTYTRASH')     => 'trash',
            );
            
            $this->initPermissions();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            if ($this->buttonClicked('doAction') && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }
            
            if ($this->buttonClicked('doAction') && !is_null($this->getRequestVar('actions'))) {
                
                $actionData = $this->getRequestVar('actions');

                if ((!isset($actionData['ids']) && $actionData['action'] != 'trash') || !$actionData['action']) {
                    $this->view->addErrorMessage('SELECT_ITEMS_MSG');
                    $this->initPagination();
                    return true;
                }
                
                $ids = ($actionData['action'] == 'trash') ? array() : array_map('intval', $actionData['ids']);
                
                $action = in_array($actionData['action'], array_values($this->articleActions))
                        ? $actionData['action']
                        : false;
                
                if ($action === false) {
                    $this->view->addErrorMessage('SELECT_ITEMS_MSG');
                    $this->initPagination();
                    return true;                    
                }

                if (!call_user_func(array($this, 'do'.  ucfirst($action)), $ids)) {
                    
                    if ($action == 'delete') {
                        $msg = 'DELETE_FAILED_ARTICLE';
                    } elseif ($action == 'trash') {
                        $msg = 'DELETE_FAILED_TRASH';
                    } else {
                        $msg = 'SAVE_FAILED_ARTICLE'.strtoupper($action);
                    }
                    
                    $this->initPagination();
                    
                    $this->view->addErrorMessage($msg);
                    return true;
                }
                
                if ($action == 'delete') {
                    $msg = 'DELETE_SUCCESS_ARTICLE';
                } elseif ($action == 'trash') {
                    $msg = 'DELETE_SUCCESS_TRASH';
                } else {
                    $msg = 'SAVE_SUCCESS_ARTICLE'.strtoupper($action);
                }                
                
                $this->view->addNoticeMessage($msg);
            }
            
            $this->initPagination();
            
            return true;
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
        public function process() {
            if (!parent::process()) return false;
            
            $users = $this->userList->getUsersNameList();

            $this->view->assign('timesMode', true);
            $this->view->assign('users', array_flip($users));
            $this->view->assign('commentEnabledGlobal', $this->config->system_comments_enabled);
            $this->view->assign('showArchiveStatus', true);
            $this->view->assign('showDraftStatus', false);
            $this->view->assign('articleActions', $this->articleActions);
            $this->view->assign('showTrash', $this->config->articles_trash);
            $this->view->assign('deletePermissions', $this->deleteActions);
            
            $this->view->assign('searchUsers', $users);
            $this->view->assign('searchCategories', $this->categoryList->getCategoriesNameListCurrent());
            $this->view->assign('searchTypes', array(
                $this->lang->translate('ARTICLE_SEARCH_TYPE_ALL')   => -1,
                $this->lang->translate('ARTICLE_SEARCH_TYPE_TITLE') => 0,
                $this->lang->translate('ARTICLE_SEARCH_TYPE_TEXT')  => 1
            ));
            $this->view->assign('searchPinned', array(
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));  
            $this->view->assign('searchPostponed', array(
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));  
            $this->view->assign('searchComments', array(
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));          
            
            if ($this->config->articles_trash) {
                $this->view->assign('trash', $this->articleList->getArticlesDeleted(true));                
            }
            $this->view->assign('drafts', $this->articleList->getArticlesDraft(true));

            $commentCounts = $this->commentList->countComments($this->getArticleListIds());
            $this->view->assign('commentCount', $commentCounts);
            
            $this->view->assign('commentPrivateUnapproved', $this->commentList->countUnapprovedPrivateComments($this->getArticleListIds()));            
            
            $this->view->assign('commentSum', $commentCounts && $this->articleCount ? array_sum($commentCounts) : 0);
            
            $this->view->addJsVars(array(
                'fpcmArticlesSearchWaitMsg'  => $this->lang->translate('SEARCH_WAITMSG'),
                'fpcmArticlesSearchHeadline' => $this->lang->translate('ARTICLES_SEARCH'),
                'fpcmArticlesSearchStart'    => $this->lang->translate('ARTICLE_SEARCH_START'),
                'fpcmArticlesLastSearch'     => 0
            ));
            
            $this->translateCategories();
            
            return true;
        }
        
        /**
         * Artikel-IDs ermitteln
         * @return array
         */
        protected function getArticleListIds() {
            $articleIds = array();
            foreach ($this->articleItems as $monthData) {
                $articleIds = array_merge($articleIds, array_keys($monthData));
            }
            
            return $articleIds;
        }

        /**
         * Artikel pinnen
         * @param array $ids
         * @return bool
         */
        protected function doPinn(array $ids) {
            return $this->articleList->togglePinned($ids);
        }
        
        /**
         * Artikel archivieren
         * @param array $ids
         * @return bool
         */
        protected function doArchive(array $ids) {
            return $this->articleList->archiveArticles($ids);
        }
        
        /**
         * Kommentare de/aktivieren
         * @param array $ids
         * @return bool
         */
        protected function doComments(array $ids) {
            return $this->articleList->toggleComments($ids);
        }
        
        /**
         * Kommentare de/aktivieren
         * @param array $ids
         * @return bool
         */
        protected function doApproval(array $ids) {
            return $this->articleList->toggleApproval($ids);
        }
        
        /**
         * nicht verwendet
         * @param array $ids
         * @return boolean
         */
        protected function doNewtweet(array $ids) {
            return true;
        }
        
        /**
         * Artikel löschen
         * @param array $ids
         * @return boolean
         */
        protected function doDelete(array $ids) {
            if (!$this->deleteActions) return false;            
            return $this->articleList->deleteArticles($ids);
        }
        
        /**
         * Papierkorb leeren
         * @param array $ids
         * @return boolean
         */
        protected function doTrash(array $ids) {
            if (!$this->deleteActions || !$this->config->articles_trash) return false;            
            return $this->articleList->emptyTrash();
        }
        
        /**
         * Artikel aus Papierkorb wiederherstellen
         * @param array $ids
         * @return boolean
         */
        protected function doRestore(array $ids) {
            if (!$this->deleteActions || !$this->config->articles_trash) return false;            
            return $this->articleList->restoreArticles($ids);
        }

        /**
         * Seitenvaigation erzeugen
         */
        protected function initPagination() {
            $this->view->assign('backBtn', false);
            $this->view->assign('nextBtn', false);
            $this->view->assign('listActionLimit', '');
            
            $pageValue = 1;
            $pageCount = ceil($this->articleCount / $this->listShowLimit);
            
            if ($this->getRequestVar('page')) {
                $pageValue = (int) $this->getRequestVar('page');
                
                if ($pageValue) $this->listShowStart = ($pageValue - 1) * $this->listShowLimit;
                
                $backBtnValue = $pageValue - 1;                
                $this->view->assign('backBtn', $backBtnValue);
                
                $nextBtnValue   = $pageValue + 1;
                
                $this->view->assign('nextBtn', ($nextBtnValue <= $pageCount ? $nextBtnValue : false));
                $this->view->assign('listActionLimit', '&page='.$this->getRequestVar('page'));                
            } elseif (!$this->getRequestVar('page') &&
                      count($this->articleItems) < $this->articleCount &&
                      !(2 * $this->listShowLimit >= $this->articleCount + $this->listShowLimit) ) {

                $this->view->assign('nextBtn', 2);
            }
            
            $pageCount = ($pageCount ? $pageCount : 1);
            
            $pageSelectOptions = array();
            for ($i=1; $i<=$pageCount; $i++) {
                $pageSelectOptions[$this->lang->translate('GLOBAL_PAGER', array('{{current}}' => $i, '{{total}}' => $pageCount))] = $i;
            }

            $this->view->assign('pageSelectOptions', $pageSelectOptions);            
            $this->view->assign('pageCurrent', $pageValue);
            $this->view->assign('pageCount', $pageCount);
            $this->view->assign('showPager', true);
            $this->view->addJsVars(array('fpcmCurrentModule'=> $this->getRequestVar('module')));
        }
        
        /**
         * Initialisiert Berechtigungen
         */
        protected function initPermissions() {
            if (!$this->permissions) return false;
            
            $this->deleteActions = $this->permissions->check(array('article' => 'delete'));

            if (!$this->permissions->check(array('article' => 'delete'))) {
                unset($this->articleActions[$this->lang->translate('GLOBAL_DELETE')]);
            }

            if (!$this->permissions->check(array('article' => 'archive'))) {
                unset($this->articleActions[$this->lang->translate('EDITOR_ARCHIVE')]);
            }

            if ($this->permissions->check(array('article' => 'approve'))) {
                unset($this->articleActions[$this->lang->translate('ARTICLE_LIST_APPROVE')]);
            }

            if (!$this->deleteActions || !$this->config->articles_trash) {
                unset(
                    $this->articleActions[$this->lang->translate('ARTICLE_LIST_EMPTYTRASH')],
                    $this->articleActions[$this->lang->translate('ARTICLE_LIST_RESTOREARTICLE')]
                );
            }
            
            $this->initEditPermisions();
        }
        
    }
?>