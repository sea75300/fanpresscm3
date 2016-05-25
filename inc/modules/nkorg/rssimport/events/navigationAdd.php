<?php

namespace fpcm\modules\nkorg\rssimport\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['after'][] = array(
            'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
            'permission'        => array('system' => 'options'),
            'description'       => $this->lang->translate('NKORG_RSSIMPORT_HEADLINE'),
            'icon'              => 'fa fa-feed fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
