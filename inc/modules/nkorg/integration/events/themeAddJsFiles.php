<?php
    /**
     * FanPress CM Integration, http://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: themeAddJsFiles
     * 
     * @version 0.0.1
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\integration\events;

    class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $params[] = 'inc/modules/nkorg/integration/js/integration.js';
            
            return $params;
        }

    }