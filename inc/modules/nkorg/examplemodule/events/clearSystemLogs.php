<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class clearSystemLogs extends \fpcm\model\abstracts\moduleEvent {

    public function run() {
        \fpcm\classes\logs::syslogWrite(__CLASS__.'->'.__FUNCTION__);
    }

}
