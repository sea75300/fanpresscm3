<?php

namespace fpcm\modules\nkorg\classicimporter\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['after'][] = array(
            'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
            'permission'        => array('system' => 'options'),
            'description'       => $this->lang->translate('FPCM_CLASSICIMPORTER_HEADLINE'),
            'icon'              => 'fa fa-clipboard fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
