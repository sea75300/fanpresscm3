<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class publicReplaceSpamCaptcha extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        return new \fpcm\modules\nkorg\examplemodule\model\examplePlugin();
        
    }

}
