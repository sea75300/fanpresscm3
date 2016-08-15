<?php
    /**
     * Article list active controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistactive extends articlelistbase {

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit');
        }
        
        public function request() {
            $this->articleCount = $this->articleList->getArticlesActive(false, array(), true);
            
            parent::request();
            
            $this->articleItems = $this->articleList->getArticlesActive(true, array($this->listShowStart, $this->listShowLimit));
            
            return true;
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('headlineVar', 'HL_ARTICLE_EDIT_ACTIVE');
            $this->view->assign('listAction', 'articles/listactive');            
            $this->view->assign('list', $this->articleItems);
            $this->view->assign('showArchiveStatus', false);

            $this->view->addJsVars(array('fpcmArticleSearchMode' => 0));
            $this->initMinSearchDateValue();

            $this->view->render();
        }

    }
?>