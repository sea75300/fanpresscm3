<?php
    namespace fpcm\modules\nkorg\inactivity_manager\controller;
    
    class editmessage extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\modules\nkorg\inactivity_manager\model\message
         */
        protected $message;
        
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
            
            $id = $this->getRequestVar('id', array(7,9));
            $this->message = new \fpcm\modules\nkorg\inactivity_manager\model\message($id);
            
            
            if ($this->buttonClicked('msgSave')) {
                
                $newmessage = $this->getRequestVar('msg');
                
                $this->message->setText($newmessage['text']);
                
                $starttime = strtotime($newmessage['start']);
                $this->message->setStarttime($starttime);

                $stoptime = strtotime($newmessage['stop']);
                $this->message->setStoptime($stoptime);
                
                $commentsDiabled = (isset($newmessage['nocomments']) ? true : false);
                $this->message->setNocomments($commentsDiabled);
                
                $res = $this->message->update();
                
                if ($res) {
                    $this->redirect('modules/config', array(
                        'key' => \fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__),
                        'added' => 1
                    ));
                    
                    return true;
                }
                
                $this->view->addErrorMessage('NKORGINACTIVITY_MANAGER_SAVED_FAILED');
                
            }
            
            return parent::request();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('msg', $this->message);
            $this->view->assign('additional', '&id='.$this->message->getId());
            $this->view->addJsVars(array(
                'fpcmInactivityDatePicker'    => array(
                    'daysfull'              => $this->lang->getDays(),
                    'daysshort'             => $this->lang->getDaysShort(),
                    'months'                => array_values($this->lang->getMonths())
                )
            ));
            $this->view->render();
            
        }

    }
?>