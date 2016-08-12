<?php
    /**
     * Inactivity Manager, https://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: parseTemplateArticle
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class parseTemplateArticle extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $messages = new \fpcm\modules\nkorg\inactivity_manager\model\messages();
            $messageList = $messages->getMessages(true);
            
            $messageString = '';
            if (!count($messageList)) {
                return $params;
            }

            foreach ($messageList as $message) {
                $messageString .= (string) $message;
            }
            $params['{{inactivityManagerMessages}}'] = $messageString;

            return $params;
        }

    }