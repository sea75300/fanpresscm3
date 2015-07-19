<?php

namespace fpcm\modules\nkorg\modulecreator\events;

class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params[] = 'inc/modules/nkorg/modulecreator/js/nkorgmodulecreator.js';
        
        return $params;
        
    }

}
