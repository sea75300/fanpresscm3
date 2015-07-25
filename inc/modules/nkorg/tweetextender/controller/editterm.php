<?php
    namespace fpcm\modules\nkorg\tweetextender\controller;
    
    class editterm extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\modules\nkorg\tweetextender\model\term
         */
        protected $term;
        
        /**
         *
         * @var \fpcm\model\view\module
         */
        protected $view;

        public function __construct() {
            
            $this->view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__) , 'acp', 'editor');
            
            return parent::__construct();
        }

        public function request() {
            
            if (!$this->getRequestVar('id')) {
                return false;
            }
            
            $id = (int) $this->getRequestVar('id');
            $this->term = new \fpcm\modules\nkorg\tweetextender\model\term($id);
            
            if ($this->buttonClicked('termSave')) {
                
                $newterm = $this->getRequestVar('term');
                
                $this->term->setSearchterm($newterm['search']);
                $this->term->setReplaceterm($newterm['replace']);
                
                $res = $this->term->update();
                
                if ($res) {
                    $this->redirect('modules/config', array(
                        'key' => \fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__),
                        'added' => 1
                    ));
                    
                    return true;
                }
                
                $this->view->addErrorMessage('NKORG_TWEETENTENDER_SAVED_FAILED');
                
            }
            
            return parent::request();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('term', $this->term);
            $this->view->assign('additional', '&id='.$this->term->getId());
            $this->view->render();
            
        }

    }
?>