<?php
    /**
     * Article list active controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistactive extends articlelistbase {

        /**
         *
         * @var bool
         */
        protected $showDraftStatus = false;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit');
        }
        
        public function request() {
            
            $conditions = array(
                'draft'    => -1,
                'archived' => 0,
                'limit'    => array($this->listShowLimit, $this->listShowStart)
            );
            
            $this->articleCount = $this->articleList->countArticlesByCondition($conditions);
            
            parent::request();            

            $this->articleItems = $this->articleList->getArticlesByCondition($conditions, true);
            
            return true;
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('headlineVar', 'HL_ARTICLE_EDIT_ACTIVE');
            $this->view->assign('listAction', 'articles/listactive');            
            $this->view->assign('list', $this->articleItems);
            $this->view->assign('showArchiveStatus', false);

            $minMax = $this->articleList->getMinMaxDate(0);
            $this->view->addJsVars(array(
                'fpcmArticleSearchMode'   => 0,
                'fpcmArticlSearchMinDate' => date('Y-m-d', $minMax['minDate'])
            ));

            $this->view->render();
        }

    }
?>