<?php
    /**
     * Article list all controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistall extends articlelistbase {

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit', 'article' => 'editall');
        }

        public function request() {

            $conditions = [
                'draft'    => -1,
                'approval' => -1
            ];

            $this->articleCount = $this->articleList->countArticlesByCondition($conditions);
            
            parent::request();            
            
            $conditions['limit'] = [$this->listShowLimit, $this->listShowStart];
            $this->articleItems = $this->articleList->getArticlesByCondition($conditions, true);

            return true;
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('headlineVar', 'HL_ARTICLE_EDIT_ALL');
            $this->view->assign('listAction', 'articles/listall');
            $this->view->assign('list', $this->articleItems);
            
            $minMax = $this->articleList->getMinMaxDate();
            $this->view->addJsVars(array(
                'fpcmArticleSearchMode'   => -1,
                'fpcmArticlSearchMinDate' => date('Y-m-d', $minMax['minDate'])
            ));
            
            $this->view->render();
        }

    }
?>