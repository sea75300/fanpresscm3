<?php
    /**
     * AJAX add message controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\common;
    
    /**
     * AJAX-Controller zum Erzeugen und Ausgeben einer neuen Nachricht
     * 
     * @package fpcm.controller.ajax.commom.addmsg
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class addmsg extends \fpcm\controller\abstracts\ajaxController {

        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $view = new \fpcm\model\view\ajax();
            
            $type = $this->getRequestVar('type');
            $msg  = $this->getRequestVar('msgtxt');
            
            switch ($type) {
                case 'error' :
                    $view->addErrorMessage($msg);
                    break;
                case 'notice' :
                    $view->addNoticeMessage($msg);
                    break;
                default:
                    $view->addMessage($msg);
                    break;
            }

            \fpcm\classes\logs::syslogWrite($view->getMessages());
            
            $view->render();
        }

    }
?>