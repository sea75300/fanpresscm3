<?php
    /**
     * Article trash controller
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.5
     */
    namespace fpcm\controller\action\articles;
    
    class articlelisttrash extends articlelistbase {

        public function __construct() {
            parent::__construct();

            $this->view            = new \fpcm\model\view\acp('listtrash', 'articles');
            $this->checkPermission = ['article' => 'edit', 'article' => 'editall'];

            $this->articleActions   = [
                $this->lang->translate('ARTICLE_LIST_RESTOREARTICLE') => 'restore',
                $this->lang->translate('ARTICLE_LIST_EMPTYTRASH') => 'trash',
            ];
        }
        
        public function request() {
            $this->articleItems = $this->articleList->getArticlesDeleted(true);
            return parent::request();
        }
        
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('listAction', 'articles/trash');
            $this->view->assign('showTrash', $this->config->articles_trash);

            $this->view->render();
        }

    }
?>