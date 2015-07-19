<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class themeAddCssFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params[] = 'css/dummy.css';
        
        return $params;
        
    }

}
