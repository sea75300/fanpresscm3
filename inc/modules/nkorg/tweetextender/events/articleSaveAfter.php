<?php
    /**
     * Tweet Extender, http://nobody-knows.org/
     *
     * nkorg/tweetextender event class: articleSaveAfter
     * 
     * @version 3.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\tweetextender\events;

    class articleSaveAfter extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            // check FanPress CM documentation, if this events requires a return value
            return $params;
        }

    }