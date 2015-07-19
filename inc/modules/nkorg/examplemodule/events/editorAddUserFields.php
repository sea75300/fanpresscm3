<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class editorAddUserFields extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params[$this->lang->translate('FPCM_EXAMPLEMODULE_HEADLINE')] = array(
            'name'     => 'nkorg/examplemodule',
            'value'    => 'dummy',
            'class'    => 'dummy',
            'readonly' => false,
            'lenght'   => 32
        );
        
        
        return $params;
        
    }

}
