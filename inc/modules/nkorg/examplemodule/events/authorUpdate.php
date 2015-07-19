<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class authorUpdate extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        \fpcm\classes\logs::syslogWrite($params);
        
        return $params;
        
    }

}
