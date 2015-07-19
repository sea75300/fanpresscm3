<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class editorInitHtml extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $params['extraButtons'][] = array(
            'title'     => 'FanPress CM Module Example Button',
            'id'        => basename(dirname(__DIR__)).'1',
            'class'     => 'fpcm-editor-htmlclick',
            'htmltag'   => 'fpcm1',
            'icon'      => 'fa fa-mars-double'
        );
        
        $params['extraButtons'][] = array(
            'title'     => 'FanPress CM Module Example Button 2',
            'id'        => basename(dirname(__DIR__)).'1',
            'class'     => 'fpcm-editor-htmlclick',
            'htmltag'   => 'fpcm2',
            'icon'      => 'fa fa-venus-double'
        );        
        
        return $params;        
    }

}
