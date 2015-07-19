<?php
    /**
     * Article list all controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistall extends articlelistbase {

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit', 'article' => 'editall');
        }
        
        public function request() {
            $this->articleCount = $this->articleList->getArticlesAll(false, array(), true);
            
            parent::request();            
            
            $this->articleItems = $this->articleList->getArticlesAll(true, array($this->listShowStart, $this->listShowLimit));
            
            return true;
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('headlineVar', 'HL_ARTICLE_EDIT_ALL');
            $this->view->assign('listAction', 'articles/listall');
            $this->view->assign('list', $this->articleItems);
            
            $this->view->addJsVars(array('fpcmArticleSearchMode' => -1));
            
            $this->view->render();
        }

    }
?>