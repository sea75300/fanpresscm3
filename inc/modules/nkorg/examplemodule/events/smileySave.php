<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class smileySave extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        \fpcm\classes\logs::syslogWrite(array(
            __CLASS__.'->'.__FUNCTION__,
            $params
        ));
        
        return $params;
        
    }

}
