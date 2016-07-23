<?php
    /**
     * Wordban item add controller
     * @item Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\wordban;
    
    class itemadd extends \fpcm\controller\abstracts\controller {
        
        protected $view;

        protected $item;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'wordban');
            
            $this->view = new \fpcm\model\view\acp('itemadd', 'wordban');
            $this->item = new \fpcm\model\wordban\item();
        }

        public function request() {

            if ($this->buttonClicked('wbitemSave')) {

                $data = $this->getRequestVar('wbitem');
                
                $this->item->setSearchtext($data['searchtext']);
                $this->item->setReplacementtext($data['replacementtext']);

                $res = $this->item->save();

                if ($res === false) $this->view->addErrorMessage('SAVE_FAILED_WORDBAN');
                if ($res === true) $this->redirect('wordban/list', array('added' => 1));
            }
            
            return true;
            
        }
        
        public function process() {
            if (!parent::process()) return false;
       
            $this->view->assign('item', $this->item);
            
            $this->view->render();            
        }

    }
?>