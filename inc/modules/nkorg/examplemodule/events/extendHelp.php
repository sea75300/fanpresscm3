<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class extendHelp extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['HELP_SELECT'] = 'FPCM Example Module Help Entry';
        
        return $params;
        
    }

}
