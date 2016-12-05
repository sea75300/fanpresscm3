<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: clearSystemLog
     * 
     * @version 3.4.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class clearSystemLog extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            if ($params !== 'nkorgexample') {
                return false;
            }

            \fpcm\modules\nkorg\example\model\logfile::cleanup();

            return true;
        }

    }