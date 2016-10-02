<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: publicPageinationShowArchive
     * 
     * @version 3.4.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class publicPageinationShowArchive extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            \fpcm\modules\nkorg\example\model\logfile::logParams($params);
            return $params;
        }

    }