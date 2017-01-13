<?php
    /**
     * Article list controller base
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
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
        protected $articleActions = [];

        /**
         *
         * @var array
         */
        protected $articleItems = [];
        
        /**
         *
         * @var bool
         */
        protected $deleteActions = false;
        
        /**
         *
         * @var bool
         */
        protected $showDraftStatus = true;
        
        /**
         *
         * @var int
         */
        protected $listShowLimit = 0;
        
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
            
            $this->articleActions   = [
                $this->lang->translate('ARTICLE_LIST_PINNED')         => 'pinn',
                $this->lang->translate('ARTICLE_LIST_APPROVE')        => 'approval',
                $this->lang->translate('EDITOR_ARCHIVE')              => 'archive',
                $this->lang->translate('ARTICLE_LIST_COMMENTS')       => 'comments',
                $this->lang->translate('ARTICLE_LIST_NEWTWEET')       => 'newtweet',
                $this->lang->translate('GLOBAL_DELETE')               => 'delete'
            ];
            
            $this->initPermissions();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            if (($this->buttonClicked('doAction') || $this->buttonClicked('clearTrash')) && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }

            if ($this->buttonClicked('doAction') && !is_null($this->getRequestVar('actions'))) {
                
                $actionData = $this->getRequestVar('actions');

                if ($actionData['action'] === 'trash') {
                    
                    if (!$this->doTrash()) {
                        $this->view->addErrorMessage('DELETE_FAILED_TRASH');                    
                    }
                    else {
                        $this->view->addNoticeMessage('DELETE_SUCCESS_TRASH');
                    }

                    return true;
                }

                
                if ((!isset($actionData['ids']) && $actionData['action'] != 'trash') || !$actionData['action']) {
                    $this->view->addErrorMessage('SELECT_ITEMS_MSG');
                    $this->initPagination();
                    return true;
                }

                $ids = array_map('intval', $actionData['ids']);
                
                $action = in_array($actionData['action'], array_values($this->articleActions))
                        ? $actionData['action']
                        : false;
                
                if ($action === false) {
                    $this->view->addErrorMessage('SELECT_ITEMS_MSG');
                    $this->initPagination();
                    return true;                    
                }

                if (!call_user_func([$this, 'do'.  ucfirst($action)], $ids)) {
                    $msg = ($action == 'delete')  ? 'DELETE_FAILED_ARTICLE' : 'SAVE_FAILED_ARTICLE';
                    $this->initPagination();
                    $this->view->addErrorMessage($msg);
                    return true;
                }
                
                $msg = ($action == 'delete')  ? 'DELETE_SUCCESS_ARTICLE' : 'SAVE_SUCCESS_ARTICLE'.strtoupper($action);                
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
            $this->view->assign('showDraftStatus', $this->showDraftStatus);
            $this->view->assign('articleActions', $this->articleActions);
            $this->view->assign('showTrash', false);
            $this->view->assign('deletePermissions', $this->deleteActions);
            $this->view->assign('list', $this->articleItems);
            
            $this->initSearchForm($users);

            $commentCounts = $this->commentList->countComments($this->getArticleListIds());

            $this->view->assign('commentCount', $commentCounts);
            $this->view->assign('commentPrivateUnapproved', $this->commentList->countUnapprovedPrivateComments($this->getArticleListIds()));            
            $this->view->assign('commentSum', $commentCounts && $this->articleCount ? array_sum($commentCounts) : 0);
            
            $this->view->setViewJsFiles([\fpcm\classes\baseconfig::$jsPath.'articlelist.js']);
            
            $this->translateCategories();
            
            return true;
        }
        
        /**
         * Artikel-IDs ermitteln
         * @return array
         */
        protected function getArticleListIds() {
            $articleIds = [];
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
         * @return boolean
         */
        protected function doTrash() {
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
            
            $page       = $this->getRequestVar('page', [9]);
            $pagerData  = \fpcm\classes\tools::calcPagination(
                $this->listShowLimit,
                $page,
                $this->articleCount,
                count($this->articleItems)
            );

            $this->listShowStart = \fpcm\classes\tools::getPageOffset($page, $this->listShowLimit);

            $this->view->assign('showPager', true);
            foreach ($pagerData as $key => $value) {
                $this->view->assign($key, $value);
            }
            
            $this->view->addJsVars(['fpcmCurrentModule'=> $this->getRequestVar('module')]);
        }
        
        /**
         * Initialisiert Berechtigungen
         */
        protected function initPermissions() {
            if (!$this->permissions) return false;
            
            $this->deleteActions = $this->permissions->check(['article' => 'delete']);

            if (!$this->permissions->check(['article' => 'delete'])) {
                unset($this->articleActions[$this->lang->translate('GLOBAL_DELETE')]);
            }

            if (!$this->permissions->check(['article' => 'archive'])) {
                unset($this->articleActions[$this->lang->translate('EDITOR_ARCHIVE')]);
            }

            if ($this->permissions->check(['article' => 'approve'])) {
                unset($this->articleActions[$this->lang->translate('ARTICLE_LIST_APPROVE')]);
            }
            
            $this->initEditPermisions();
        }
        
        /**
         * Initialisiert Suchformular-Daten
         * @param array $users
         */
        private function initSearchForm($users) {

            $users = [$this->lang->translate('ARTICLE_SEARCH_USER') => -1] + $users;
            $this->view->assign('searchUsers', $users);
            
            $categories = [$this->lang->translate('ARTICLE_SEARCH_CATEGORY') => -1] + $this->categoryList->getCategoriesNameListCurrent();
            $this->view->assign('searchCategories', $categories);

            $this->view->assign('searchTypes', [
                $this->lang->translate('ARTICLE_SEARCH_TYPE_ALL')   => -1,
                $this->lang->translate('ARTICLE_SEARCH_TYPE_TITLE') => 0,
                $this->lang->translate('ARTICLE_SEARCH_TYPE_TEXT')  => 1
            ]);
            $this->view->assign('searchPinned', [
                $this->lang->translate('ARTICLE_SEARCH_PINNED') => -1,
                $this->lang->translate('GLOBAL_YES') => 1,
                $this->lang->translate('GLOBAL_NO')  => 0
            ]);
            $this->view->assign('searchPostponed', [
                $this->lang->translate('ARTICLE_SEARCH_POSTPONED') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ]);

            $this->view->assign('searchComments', [
                $this->lang->translate('ARTICLE_SEARCH_COMMENTS') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ]);
            $this->view->assign('searchApproval', [
                $this->lang->translate('ARTICLE_SEARCH_APPROVAL') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ]);
            $this->view->assign('searchCombination', [
                $this->lang->translate('ARTICLE_SEARCH_LOGICAND') => 0,
                $this->lang->translate('ARTICLE_SEARCH_LOGICOR')  => 1
            ]);

            $this->view->addJsLangVars([
                'searchWaitMsg'      => $this->lang->translate('SEARCH_WAITMSG'),
                'searchHeadline'     => $this->lang->translate('ARTICLES_SEARCH'),
                'searchStart'        => $this->lang->translate('ARTICLE_SEARCH_START')
            ]);

            $this->view->addJsVars(['fpcmArticlesLastSearch' => 0]);
        }
        
    }
?>
