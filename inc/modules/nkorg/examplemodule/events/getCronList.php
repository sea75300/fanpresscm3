<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class getCronList extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        \fpcm\classes\logs::syslogWrite(array(
            get_class(),
            $params
        ));
        
        return $params;
        
    }

}
