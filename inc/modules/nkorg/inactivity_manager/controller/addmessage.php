<?php
    namespace fpcm\modules\nkorg\inactivity_manager\controller;
    
    class addmessage extends \fpcm\controller\abstracts\controller {
        
        protected $message;
        
        protected $view;

        public function __construct() {
            
            $this->message = new \fpcm\modules\nkorg\inactivity_manager\model\message();
            $this->view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__) , 'acp', 'editor');
            
            return parent::__construct();
        }

        public function request() {
            
            if ($this->buttonClicked('msgSave')) {
                
                $newmessage = $this->getRequestVar('msg');
                
                $this->message->setText($newmessage['text']);
                
                $starttime = strtotime($newmessage['start']);
                $this->message->setStarttime($starttime);

                $stoptime = strtotime($newmessage['stop']);
                $this->message->setStoptime($stoptime);
                
                $res = $this->message->save();
                
                if ($res) {
                    $this->redirect('modules/config', array(
                        'key'   => \fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__),
                        'added' => 1
                    ));
                    
                    return true;
                }
                
                $this->view->addErrorMessage('NKORGINACTIVITY_MANAGER_SAVED_FAILED');                
            } else {
                $timer = time();
                $this->message->setStarttime($timer);
                $this->message->setStoptime($timer + 3600 * 24);
            }
            
            return parent::request();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('msg', $this->message);
            $this->view->assign('additional', '');
            $this->view->addJsVars(array(
                'fpcmInactivityDatePicker'  => array(
                    'daysfull'              => $this->lang->getDays(),
                    'daysshort'             => $this->lang->getDaysShort(),
                    'months'                => array_values($this->lang->getMonths())
                )
            ));
            $this->view->render();
            
        }

    }
?>