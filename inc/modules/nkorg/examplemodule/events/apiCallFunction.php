<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class apiCallFunction extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        fpcmDump(__CLASS__.'->'.__FUNCTION__, $params);
        
        return true;
        
        
    }

}
