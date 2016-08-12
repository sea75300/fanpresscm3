<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class editorGetFileList extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['files'][] = array($params['label'] => 'Pottiga Aussichtplattform', 'value' => 'https://nobody-knows.org/gallery/landschaftsaufnahmen/thumbs/thumbs_2011-04-25_16-15-06_652.jpg');
        
        return $params;
        
    }

}
