<?php
    /**
     * Wordban item edit controller
     * @item Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\wordban;
    
    class itemedit extends \fpcm\controller\abstracts\controller {
        
        protected $view;

        /**
         *
         * @var \fpcm\model\wordban\item
         */
        protected $item;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'options');
            $this->view = new \fpcm\model\view\acp('itemedit', 'wordban');
            
        }

        public function request() {

            if (is_null($this->getRequestVar('itemid'))) {
                $this->redirect('wordban/list');
            }
            
            $this->item = new \fpcm\model\wordban\item($this->getRequestVar('itemid', array(9)));
            
            if (!$this->item->exists()) {
                $this->view->setNotFound('LOAD_FAILED_WORDBAN', 'wordban/list');
                return true;
            }            
            
            if ($this->buttonClicked('wbitemSave')) {
                $data = $this->getRequestVar('wbitem');
                
                $this->item->setSearchtext($data['searchtext']);
                $this->item->setReplacementtext($data['replacementtext']);

                $res = $this->item->update();

                if ($res === false) $this->view->addErrorMessage('SAVE_FAILED_WORDBAN');
                if ($res === true) $this->redirect ('wordban/list', array('edited' => 1));
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