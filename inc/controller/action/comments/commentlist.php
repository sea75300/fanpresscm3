<?php
    /**
     * Comment list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\comments;
    
    class commentlist extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\comments\lists;
        
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
            
            if (!$this->buttonClicked('doAction')) {
                return true;
            }

            if (!$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }
           
            return $this->processCommentActions($this->list);
        }
        
        /**
         * @see \fpcm\controller\abstracts\controller::process()
         * @return mixed
         */        
        public function process() {

            if (!parent::process()) return false;

            $this->initCommentPermissions();
            $this->initSearchForm();

            $this->view->setViewJsFiles(array(\fpcm\classes\baseconfig::$jsPath.'comments.js'));
            $this->view->assign('comments', $this->list->getCommentsAll());
            $this->view->assign('commentsMode', 1);
            $this->view->render();
        }
        
        /**
         * Initialisiert Suchformular-Daten
         * @param array $users
         */
        private function initSearchForm() {

            $this->view->assign('searchTypes', array(
                $this->lang->translate('COMMENTS_SEARCH_TYPE_ALL')  => 0,
                $this->lang->translate('COMMENTS_SEARCH_TYPE_TEXT') => 1
            ));

            $this->view->assign('searchApproval', array(
                $this->lang->translate('COMMMENT_APPROVE') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));

            $this->view->assign('searchSpam', array(
                $this->lang->translate('COMMMENT_SPAM') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));

            $this->view->assign('searchPrivate', array(
                $this->lang->translate('COMMMENT_PRIVATE') => -1,
                $this->lang->translate('GLOBAL_YES')  => 1,
                $this->lang->translate('GLOBAL_NO') => 0
            ));
            $this->view->assign('searchCombination', array(
                $this->lang->translate('ARTICLE_SEARCH_LOGICAND') => 0,
                $this->lang->translate('ARTICLE_SEARCH_LOGICOR')  => 1
            ));
            
            $this->view->addJsLangVars(array(
                'searchWaitMsg'      => $this->lang->translate('SEARCH_WAITMSG'),
                'searchHeadline'     => $this->lang->translate('ARTICLES_SEARCH'),
                'searchStart'        => $this->lang->translate('ARTICLE_SEARCH_START')
            ));

            $this->view->addJsVars(array('fpcmCommentsLastSearch' => 0));
        }

    }
?>