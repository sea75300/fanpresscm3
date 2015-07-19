<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class getRevision extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        \fpcm\classes\logs::syslogWrite(__CLASS__.'->'.__FUNCTION__.' exec...');
        
        return $params;
        
    }

}
