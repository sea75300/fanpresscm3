<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: extendHelp
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class extendHelp extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $params['NKORGINACTIVITY_MANAGER_HEADLINE'] = $this->lang->translate('NKORGINACTIVITY_MANAGER_HELP');
            
            return $params;
        }

    }