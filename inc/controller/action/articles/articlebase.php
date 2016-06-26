<?php
    /**
     * Article controller base
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\articles;
    
    class articlebase extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var \fpcm\model\articles\article
         */
        protected $article;
        
        /**
         *
         * @var \fpcm\model\system\fileLib
         */
        protected $fileLib;

        /**
         *
         * @var array
         */
        protected $jsVars = array();

        /**
         *
         * @var string
         */
        protected $editorFile;
        
        /**
         *
         * @var \fpcm\model\categories\categoryList
         */
        protected $categoryList;
        
        /**
         *
         * @var \fpcm\model\abstracts\articleEditor
         */
        protected $editorPlugin;

        public function __construct() {
            parent::__construct();
            $this->categoryList = new \fpcm\model\categories\categoryList();
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            $eventResult = $this->events->runEvent('articleReplaceEditorPlugin');
            if (is_a($eventResult, '\fpcm\model\abstracts\articleEditor')) {
                $this->editorPlugin = $eventResult;
            } elseif ($this->config->system_editor) {
               $this->editorPlugin = new \fpcm\model\editor\htmlEditor();
            } else {
                $this->editorPlugin = new \fpcm\model\editor\tinymceEditor();
            }
            
            $this->view->setViewJsFiles($this->editorPlugin->getJsFiles());
            $this->view->setViewCssFiles($this->editorPlugin->getCssFiles());
            
            $viewVars = $this->editorPlugin->getViewVars();
            foreach ($viewVars as $key => $value) {
                $this->view->assign($key, $value);
            }

            $this->view->assign('userIsAdmin', $this->session->getCurrentUser()->isAdmin());
            if ($this->session->getCurrentUser()->isAdmin()) {
                $userlist = new \fpcm\model\users\userList();
                $this->view->assign('changeuserList', $userlist->getUsersNameList());
            }
            
            $this->view->assign('editorFile', $this->editorPlugin->getEditorTemplate());
            $this->view->assign('article', $this->article);
            $this->view->assign('categories', $this->categoryList->getCategoriesCurrentUser());
            $this->view->assign('commentEnabledGlobal', $this->config->system_comments_enabled);
            $this->view->assign('showArchiveStatus', true);
            $this->view->assign('showDraftStatus', true);
            $this->view->assign('isRevision', false);
            $this->view->assign('timesMode', false);
            $this->view->assign('userfields', $this->getUserFields());
            
            $this->jsVars  = $this->editorPlugin->getJsVars();
            $this->jsVars += array(
                'fpcmFileManagerHeadline'   => $this->lang->translate('HL_FILES_MNG'),
                'fpcmFileManagerUrl'        => \fpcm\classes\baseconfig::$rootPath.'index.php?module=files/list&mode=',
                'fpcmFileManagerUrlMode'    => 2,
                'fpcmPostponeDatePicker'    => array(
                    'daysfull'              => $this->lang->getDays(),
                    'daysshort'             => $this->lang->getDaysShort(),
                    'months'                => array_values($this->lang->getMonths())
                ),
                'fpcmExtended'              => $this->lang->translate('GLOBAL_EXTENDED')
            );
            
            $this->view->addJsVars($this->jsVars);
            
            return true;
        }
        
        /**
         * Liefert benutzerdefinierte Felder zurück, welche durch Module in Editor eingefügt werden können;
         * * möglich sind textarea, select, checkbox, radio, textinput
         * * nicht unterstütze Typen werden zu textinput
         * @return array
         */
        protected function getUserFields() {
            $fields = $this->events->runEvent('editorAddUserFields');
            
            if (!is_array($fields) || !count($fields)) return array();
            
            return $fields;
        }
    }
?>