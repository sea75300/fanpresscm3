<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: themeAddJsFiles
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            if (strpos(\fpcm\classes\http::get('module'), 'nkorg/inactivity_manager/') === false) {
                return $params;
            }           
            
            $params[] = 'inc/modules/nkorg/inactivity_manager/js/inactivitymanager.js';
            
            return $params;
        }

    }