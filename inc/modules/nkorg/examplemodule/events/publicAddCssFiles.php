<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class publicAddCssFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params[] = 'css/dummy.css';
        
        return $params;
        
    }

}
