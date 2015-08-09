<?php

namespace fpcm\modules\nkorg\integration;

class nkorgintegration extends \fpcm\model\abstracts\module {
    
    public function runInstall() { 
        return true;
    }

    public function runUninstall() {
        return true;
    }

    public function runUpdate() {
        return true;
    }

}
