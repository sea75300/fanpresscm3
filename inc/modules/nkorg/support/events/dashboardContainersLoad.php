<?php
    /**
     * FanPress CM Support Module, http://nobody-knows.org
     *
     * nkorg/support event class: dashboardContainersLoad
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\support\events;

    class dashboardContainersLoad extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            // check FanPress CM documentation, if this events requires a return value
            return $params;
        }

    }