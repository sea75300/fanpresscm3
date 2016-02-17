<?php
    /**
     * Template controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class templates extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         *
         * @var \fpcm\model\pubtemplates\article
         */
        protected $articleTemplate;

        /**
         *
         * @var \fpcm\model\pubtemplates\article
         */
        protected $articleSingleTemplate;

        /**
         *
         * @var \fpcm\model\pubtemplates\comment
         */        
        protected $commentTemplate;

        /**
         *
         * @var \fpcm\model\pubtemplates\commentform
         */        
        protected $commentFormTemplate;

        /**
         *
         * @var \fpcm\model\pubtemplates\latestnews
         */        
        protected $latestNewsTemplate;

        /**
         *
         * @var \fpcm\model\pubtemplates\tweet
         */        
        protected $tweetTemplate;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'templates');

            $this->view   = new \fpcm\model\view\acp('overview', 'templates');
            
            $fileLib = new \fpcm\model\system\fileLib();
            
            $this->view->setViewJsFiles($fileLib->getCmJsFiles());
            $this->view->setViewCssFiles($fileLib->getCmCssFiles());
            
            $this->articleTemplate       = new \fpcm\model\pubtemplates\article($this->config->articles_template_active);
            
            if ($this->config->articles_template_active != $this->config->article_template_active) {
                $this->articleSingleTemplate = new \fpcm\model\pubtemplates\article($this->config->article_template_active);                
            }
            $this->commentTemplate       = new \fpcm\model\pubtemplates\comment($this->config->comments_template_active);            
            $this->commentFormTemplate   = new \fpcm\model\pubtemplates\commentform();
            $this->latestNewsTemplate    = new \fpcm\model\pubtemplates\latestnews();
            $this->tweetTemplate         = new \fpcm\model\pubtemplates\tweet();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            if ($this->buttonClicked('saveTemplates') && !is_null($this->getRequestVar('template'))) {
                
                $this->cache->cleanup();
                
                $templateContents = $this->getRequestVar('template');
                
                $tplSaveError = array();
                $tplSaveOk = array();
                foreach ($templateContents as $templateName => $newContent) {
                    $tplObj = $this->{$templateName.'Template'};
                    $tplObj->setContent($newContent);
                    
                    $res = $tplObj->save();
                    
                    if (is_null($res) && $templateName == 'commentForm') {
                        $this->view->addErrorMessage('SAVE_FAILED_TEMPLATE_CF_URLMISSING');
                    } elseif (!$res) {
                        $tplSaveError[] = $tplObj->getFilename();
                    } else {
                        $tplSaveOk[] = $tplObj->getFilename();
                    }
                }       
                
                if (count($tplSaveError)) {
                    $this->view->addErrorMessage('SAVE_FAILED_TEMPLATE', array('{{filenames}}' => implode(', ', $tplSaveError)));                    
                }
                
                if (count($tplSaveOk)) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_TEMPLATE', array('{{filenames}}' => implode(', ', $tplSaveOk)));                    
                }                
            }
            
            return true;
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('replacementsArticle', $this->getReplacementTranslations('TEMPLATE_ARTICLE_', $this->articleTemplate->getReplacementTags()));
            $this->view->assign('contentArticle', $this->articleTemplate->getContent());
            
            if ($this->config->articles_template_active != $this->config->article_template_active) {
                $this->view->assign('replacementsArticleSingle', $this->getReplacementTranslations('TEMPLATE_ARTICLE_', $this->articleSingleTemplate->getReplacementTags()));
                $this->view->assign('contentArticleSingle', $this->articleSingleTemplate->getContent());                
            }
            
            $this->view->assign('replacementsComment', $this->getReplacementTranslations('TEMPLATE_COMMMENT_', $this->commentTemplate->getReplacementTags()));
            $this->view->assign('contentComment', $this->commentTemplate->getContent());
            
            $this->view->assign('replacementsCommentForm', $this->getReplacementTranslations('TEMPLATE_COMMMENTFORM_', $this->commentFormTemplate->getReplacementTags()));
            $this->view->assign('contentCommentForm', $this->commentFormTemplate->getContent());
            
            $this->view->assign('replacementsLatestNews', $this->getReplacementTranslations('TEMPLATE_ARTICLE_', $this->latestNewsTemplate->getReplacementTags()));
            $this->view->assign('contentLatestNews', $this->latestNewsTemplate->getContent());
            
            $this->view->assign('replacementsTweet', $this->getReplacementTranslations('TEMPLATE_ARTICLE_', $this->tweetTemplate->getReplacementTags()));
            $this->view->assign('contentTweet', $this->tweetTemplate->getContent());            
            
            $this->view->assign('allowedTags', htmlentities($this->articleTemplate->getAllowedTags(', ')));
            
            $this->view->addJsVars(array(
                'fpcmPreviewHeadline' => $this->lang->translate('HL_TEMPLATE_PREVIEW'),
                'fpcmTemplateId'      => 1
            ));
            
            $this->view->render();
        }
        
        /**
         * Platzhalter-Übersetzungen
         * @param string $prefix
         * @param array $replacements
         * @return array
         */
        private function getReplacementTranslations($prefix, array $replacements) {
            
            foreach ($replacements as $key => &$value) {
                $key = explode(':', strtoupper(str_replace(array('{{', '}}'), '', $key)));
                $value  = $this->lang->translate($prefix.$key[0]);
            }
            
            return $replacements;
            
        }
        
    }
?>
