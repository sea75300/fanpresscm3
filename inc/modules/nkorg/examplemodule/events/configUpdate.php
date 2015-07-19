<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class configUpdate extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $tf = new \fpcm\model\files\tempfile('configUpdate', print_r($params, true));
//        $tf->save();
        
        return $params;
        
    }

}
