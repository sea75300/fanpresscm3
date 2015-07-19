<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['addnews'][] = array(
            'url'               => 'dummy/test',
            'permission'        => array('article' => 'add'),
            'description'       => 'Dummy-Navigation-Link',
            'icon'              => 'fa fa-file-text fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
