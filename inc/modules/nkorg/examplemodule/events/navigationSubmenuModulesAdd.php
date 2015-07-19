<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class navigationSubmenuModulesAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params[1] = array(
            'url'               => 'dummy/test',
            'permission'        => array('article' => 'add'),
            'description'       => 'Dummy-Navigation-Module-Submenu-Link',
            'icon'              => 'fa fa-external-link-square fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
