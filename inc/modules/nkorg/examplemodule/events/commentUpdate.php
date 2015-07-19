<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class commentUpdate extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        if (!$params['website']) {
            $params['website'] = 'http://events.fanpresscm3.local';
        }
        
        return $params;
        
    }

}
