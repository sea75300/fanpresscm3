<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class fileUploadPhpBefore extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $tmp = new \fpcm\model\files\tempfile('fileUploadPhpBefore', print_r($params, true));
//        $tmp->save();
        
        return $params;
        
    }

}
