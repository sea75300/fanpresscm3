<?php
    /**
     * Inactivity Manager, https://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: parseTemplateCommentForm
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class parseTemplateCommentForm extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $messages = new \fpcm\modules\nkorg\inactivity_manager\model\messages();
            $messageList = $messages->getMessages(true, true);

            if (!count($messageList)) {
                $params['{{inactivityManagerCommentsDiabled}}'] = '';
                return $params;
            }

            $params['{{submitButton}}'] = "<button type=\"button\" disabled=\"disabled\" \">{$this->lang->translate('GLOBAL_SUBMIT')}</button>";
            $params['{{inactivityManagerCommentsDiabled}}'] = $this->lang->translate('NKORGINACTIVITY_MANAGER_NOCOMMENTS_MSG');
            
            return $params;
        }

    }