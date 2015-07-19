<?php

namespace fpcm\modules\nkorg\modulecreator\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['after'][] = array(
            'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
            'permission'        => array('system' => 'options', 'modules' => 'configure', 'modules' => 'install', 'modules' => 'enable'),
            'description'       => $this->lang->translate('NKORG_MODULECREATOR_HEADLINE'),
            'icon'              => 'fa fa-truck fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
