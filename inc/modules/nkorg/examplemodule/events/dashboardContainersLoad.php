<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class dashboardContainersLoad extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params[] = new \fpcm\modules\nkorg\examplemodule\model\exampleDashContainer();

        return $params;
        
    }

}
