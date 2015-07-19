<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class navigationRender extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $tf = new \fpcm\model\files\tempfile(get_class(), print_r($params, true));
//        $tf->save();
        
        return $params;
        
    }

}
