<?php

namespace fpcm\modules\nkorg\rssimport\events;

class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params[] = 'inc/modules/nkorg/rssimport/js/rssimport.js';
        
        return $params;
        
    }

}
