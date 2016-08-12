<?php
    /**
     * FanPress CM Integration, https://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: themeAddJsFiles
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
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