<?php
    namespace fpcm\modules\nkorg\tweetextender\controller;
    
    class addterm extends \fpcm\controller\abstracts\controller {
        
        protected $term;
        
        protected $view;

        public function __construct() {
            
            $this->term = new \fpcm\modules\nkorg\tweetextender\model\term();   
            $this->view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__) , 'acp', 'editor');
            
            return parent::__construct();
        }

        public function request() {
            
            if ($this->buttonClicked('termSave')) {
                
                $newterm = $this->getRequestVar('term');
                
                $this->term->setSearchterm($newterm['search']);
                $this->term->setReplaceterm($newterm['replace']);
                
                $res = $this->term->save();
                
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
            $this->view->render();
            
        }

    }
?>