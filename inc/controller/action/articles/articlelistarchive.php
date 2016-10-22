<?php
    /**
     * Article list active controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlelistarchive extends articlelistbase {

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('article' => 'edit', 'article' => 'editall', 'article' => 'archive');
            
            unset(
                $this->articleActions[$this->lang->translate('EDITOR_PINNED')],
                $this->articleActions[$this->lang->translate('EDITOR_ARCHIVE')]
            );            
        }
        
        public function request() {
            $this->articleCount = $this->articleList->getArticlesArchived(false, array(), true);
            
            parent::request();
            
            $this->articleItems = $this->articleList->getArticlesArchived(true, array($this->listShowStart, $this->listShowLimit));
            
            return true;
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('headlineVar', 'HL_ARTICLE_EDIT_ARCHIVE');
            $this->view->assign('listAction', 'articles/listarchive');            
            $this->view->assign('list', $this->articleItems);
            $this->view->assign('showArchiveStatus', false);
            
            $minMax = $this->articleList->getMinMaxDate(1);
            $this->view->addJsVars(array(
                'fpcmArticleSearchMode'   => 1,
                'fpcmArticlSearchMinDate' => date('Y-m-d', $minMax['minDate'])
            ));
            $this->view->assign('permAdd', false);
            $this->view->assign('showDrafts', false);

            $this->view->render();
        }

    }
?>
