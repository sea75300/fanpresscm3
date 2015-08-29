<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: acpConfig
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__) , 'acp', 'main');
            $messages = new \fpcm\modules\nkorg\inactivity_manager\model\messages();
            
            if (!is_null(\fpcm\classes\http::get('added'))) {
                $view->addNoticeMessage('NKORGINACTIVITY_MANAGER_SAVED_OK');
            }
            
            if (!is_null(\fpcm\classes\http::get('btnDeleteTerms')) && !is_null(\fpcm\classes\http::get('ids'))) {                
                $ids = \fpcm\classes\http::get('ids');
                if ($messages->deleteMessage($ids)) {
                    $view->addNoticeMessage('NKORGINACTIVITY_MANAGER_DELETE_OK');
                } else {
                    $view->addErrorMessage('NKORGINACTIVITY_MANAGER_DELETE_FAILED');
                }
            }

            $view->assign('messages', $messages->getMessage());
            
            $view->render();
        }

    }