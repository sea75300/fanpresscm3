<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class editorAddStyles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $config = new \fpcm\model\system\config();
        
        if (!$config->system_editor) {
            return $params;
        }
        
        return array_merge($params, array('Klasse 1' => 'class1{}', 'Klasse 2' => '.class2{}', 'Klasse 3' => '.class3{}'));
        
    }

}
