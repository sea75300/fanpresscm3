<?php

namespace fpcm\modules\nkorg\modulecreator;

class nkorgmodulecreator extends \fpcm\model\abstracts\module {
    
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
