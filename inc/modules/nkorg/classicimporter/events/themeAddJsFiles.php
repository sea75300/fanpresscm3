<?php

namespace fpcm\modules\nkorg\classicimporter\events;

class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        if (strpos(\fpcm\classes\http::get('module'), 'modules/config') === false) {
            return $params;
        }
        
        $params[] = 'inc/modules/nkorg/classicimporter/js/classicimporter.js';
        
        return $params;
        
    }

}
