<?php
    /**
     * Comment list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
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

            $this->view->assign('ownArticleIds', $this->articleList->getArticleIDsByUser($this->session->getUserId()));
            $this->view->assign('comments', $this->list->getCommentsAll());
            $this->view->assign('commentsMode', 1);
            $this->view->render();
        }

    }
?>