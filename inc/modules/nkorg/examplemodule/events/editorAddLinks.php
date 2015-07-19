<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class editorAddLinks extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params[] = array('label' => 'Google', 'value' => 'https://google.de');
        $params[] = array('label' => 'Yahoo', 'value' => 'https://yahoo.de');
        $params[] = array('label' => 'Bing', 'value' => 'https://bing.de');
        
        
        return $params;
        
    }

}
