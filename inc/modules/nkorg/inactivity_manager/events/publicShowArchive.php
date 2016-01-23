<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: publicShowArchive
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class publicShowArchive extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $messages = new \fpcm\modules\nkorg\inactivity_manager\model\messages();
            $messageList = $messages->getMessages(true);
            
            foreach ($messageList as $message) {
                array_unshift($params, (string) $message);                
            }
            
            return $params;
        }

    }