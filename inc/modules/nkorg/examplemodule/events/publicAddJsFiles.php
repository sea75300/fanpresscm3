<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class publicAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params[] = 'js/dummy.js';
        
        return $params;
        
    }

}
