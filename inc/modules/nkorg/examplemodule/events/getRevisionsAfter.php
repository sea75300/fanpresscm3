<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class getRevisionsAfter extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params['revisions'][time()] = 'Dummy revision added by event "getRevisionsAfter"!';
        
        return $params;
        
    }

}
