<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: publicShowAll
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class publicShowAll extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $messages = new \fpcm\modules\nkorg\inactivity_manager\model\messages();
            $messageList = $messages->getMessage(true);
            
            foreach ($messageList as $message) {
                array_unshift($params, $message);                
            }

            return $params;
        }

    }