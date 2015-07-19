<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class templateSave extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $tmp = new \fpcm\model\files\tempfile($params['file'], $params['content']);
//        $tmp->save();
        
        return $params;
        
    }

}
