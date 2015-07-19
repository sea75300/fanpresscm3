<?php

namespace fpcm\modules\nkorg\examplemodule;

class nkorgexamplemodule extends \fpcm\model\abstracts\module {
    
    public function runInstall() { 
        \fpcm\classes\logs::syslogWrite(__CLASS__.'->'.__FUNCTION__);
        return true;
    }

    public function runUninstall() {
        \fpcm\classes\logs::syslogWrite(__CLASS__.'->'.__FUNCTION__);
        return true;
    }

    public function runUpdate() {
        \fpcm\classes\logs::syslogWrite(__CLASS__.'->'.__FUNCTION__);
        return true;
    }

}
