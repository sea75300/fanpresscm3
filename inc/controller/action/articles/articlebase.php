<?php
    /**
     * Article controller base
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
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
         * Farbarray für HTML-Editor
         * @var array
         */
        protected $editorHtmlColors = array(
            '#000000','#993300','#333300','#003300','#003366','#00007f','#333398','#333333',
            '#800000','#ff6600','#808000','#007f00','#007171','#0000e8','#5d5d8b','#6c6c6c',
            '#f00000','#e28800','#8ebe00','#2f8e5f','#30bfbf','#3060f1','#770077','#8d8d8d',                
            '#f100f1','#f0c000','#eeee00','#00f200','#00efef','#00beee','#8d2f5e','#b5b5b5',
            '#ed8ebe','#efbf8f','#e8e88b','#bbeabb','#bcebeb','#89b6e4','#b88ae6','#ffffff'
        );

        public function __construct() {
            parent::__construct();
            
            $this->fileLib      = new \fpcm\model\system\fileLib();
            $this->categoryList = new \fpcm\model\categories\categoryList();
        }
        
        public function process() {
            if (!parent::process()) return false;
            
            if ($this->config->system_editor) {
                $this->initHtmlEditor();
            } else {
                $this->initTinyMCEEditor();
            }

            $this->view->assign('userIsAdmin', $this->session->getCurrentUser()->isAdmin());
            if ($this->session->getCurrentUser()->isAdmin()) {
                $userlist = new \fpcm\model\users\userList();
                $this->view->assign('changeuserList', $userlist->getUsersNameList());
            }
            
            $this->view->assign('editorFile', $this->editorFile);
            $this->view->assign('article', $this->article);
            $this->view->assign('categories', $this->categoryList->getCategoriesCurrentUser());
            $this->view->assign('commentEnabledGlobal', $this->config->system_comments_enabled);
            $this->view->assign('showArchiveStatus', true);
            $this->view->assign('showDraftStatus', true);
            $this->view->assign('isRevision', false);
            $this->view->assign('timesMode', false);
            $this->view->assign('userfields', $this->getUserFields());
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
         * HTML-Editor initialisieren
         */
        protected function initHtmlEditor() {
            $this->view->setViewJsFiles(array_merge(
                    $this->fileLib->getCmJsFiles(),
                    array(
                        \fpcm\classes\loader::libGetFileUrl('leela-colorpicker', 'leela.colorpicker-1.0.2.jquery.min.js'),
                        \fpcm\classes\baseconfig::$jsPath.'editor.js'
                    )
                )
            );
            $this->view->setViewCssFiles($this->fileLib->getCmCssFiles());

            $this->editorFile = 'html';                       
            
            $editorStyles = $this->getEditorStyles();
            $this->view->assign('editorStyles', $editorStyles);
            $this->view->assign('cssClasses', $editorStyles);            
            
            $this->jsVars = array(
                'fpcmCmColors'                  => $this->editorHtmlColors,
                'fmcEditorKeyShortcutsEnabled'  => true,
                'fpcmEditorAutocompleteLinks'   => $this->getEditorLinks(),
                'fpcmEditorAutocompleteImages'  => $this->getFileList()
            );

            $this->view->assign('targets', array(
                '_blank'  => '_blank',
                '_top'    => '_top',
                '_self'   => '_self',
                '_parent' => '_parent'
            ));

            $this->view->assign('aligns', array(
                'left'      => 'left',
                'center'    => 'center',
                'right'     => 'right'
            ));
            
            $eventData = $this->events->runEvent('editorInitHtml', array(
                'additionalData' => $this->view->getViewVars(),
                'extraButtons'   => array(array('title' => '', 'id' => '', 'class' => '', 'htmltag' => '', 'icon' => ''))
            ));
            
            $this->view->setViewVars($eventData['additionalData']);
            array_shift($eventData['extraButtons']);
            $this->view->assign('extraButtons', $eventData['extraButtons']);
        }
        
        /**
         * TinyMCE initialisieren
         */
        protected function initTinyMCEEditor() {
            
            $this->view->setViewJsFiles(array(
                \fpcm\classes\loader::libGetFileUrl('tinymce4', 'tinymce.min.js'),
                \fpcm\classes\baseconfig::$jsPath.'editor.js'
            ));
            
            $this->editorFile = 'tinymce';
            
            $editorStyles = array(array('title' => $this->lang->translate('GLOBAL_SELECT'), 'value' => ''));

            $params = array(
                'fpcmTinyMceLang'        => $this->config->system_lang,
                'fpcmTinyMceElements'     => '~readmore',
                'fpcmTinyMcePlugins'     => 'advlist anchor autolink autoresize charmap code colorpicker fullscreen hr image importcss insertdatetime link lists media nonbreaking searchreplace table textcolor textpattern visualblocks visualchars wordcount fpcm_emoticons fpcm_readmore',
                'fpcmTinyMceToolbar'     => 'formatselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify outdent indent | subscript superscript table | bullist numlist | fpcm_readmore hr blockquote | link unlink anchor image media | emoticons charmap insertdatetime | undo redo removeformat searchreplace fullscreen code',
                'fpcmTinyMceCssClasses'  => array_merge($editorStyles, $this->getEditorStyles()),
                'fpcmTinyMceLinkList'    => $this->getEditorLinks(),
                'fpcmTinyMceImageList'   => $this->getFileList(),
                'fpcmTinyMceTextpattern' => $this->getTextPatterns()
            );
            
            $this->jsVars = $this->events->runEvent('editorInitTinymce', $params);
        }
        
        /**
         * Dateiliste initialisieren
         * @return array
         */
        protected function getFileList() {
            $fileList = new \fpcm\model\files\imagelist();
            
            $label = $this->config->system_editor ? 'label' : 'title';
            
            $data = array();            
            foreach ($fileList->getDatabaseList() as $image) {
                $data[] = array($label => $image->getFilename(), 'value' => $image->getImageUrl());
            }

            $res = $this->events->runEvent('editorGetFileList', array('label' => $label, 'files' => $data));
            
            return isset($res['files']) && count($res['files']) ? $res['files'] : array();
        }
        
        /**
         * Editor-Styles initialisieren
         * @return array
         */
        protected function getEditorStyles() {
            if (!$this->config->system_editor_css) return array();
            
            $classes = explode(PHP_EOL, $this->config->system_editor_css);
            
            $editorStyles = array();
            foreach ($classes as $class) {
                if ($this->config->system_editor) {
                    $class = trim(str_replace(array('.', '{', '}'), '', $class));                
                    $editorStyles[$class] = $class;
                } else {
                    $class = trim(str_replace(array('.', '{', '}'), '', $class));                
                    $editorStyles[] = array('title' => $class, 'value' => $class);
                }
            }
            
            return $this->events->runEvent('editorAddStyles', $editorStyles);
        }
        
        /**
         * Editor-Links initialisieren
         * @return string
         */
        protected function getEditorLinks() {
            
            $links = $this->events->runEvent('editorAddLinks');
            
            if (!is_array($links) || !count($links)) return array();

            return ($this->config->system_editor) ? $links : json_decode(str_replace('label', 'title', json_encode($links)), false);
            
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
        
        /**
         * 
         * @return array
         */
        protected function getTextPatterns() {
            $patterns = array(
                array(
                    'start' => '- ',
                    'cmd'   => 'InsertUnorderedList'
                ),
                array(
                    'start' => '* ',
                    'cmd'   => 'InsertUnorderedList'
                ),
                array(
                    'start' => '1. ',
                    'cmd'   => 'InsertOrderedList'
                )
            );

            return $patterns;
        }
    }
?>