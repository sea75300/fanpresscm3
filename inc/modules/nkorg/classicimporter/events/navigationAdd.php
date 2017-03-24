<?php

namespace fpcm\modules\nkorg\classicimporter\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $item = new \fpcm\model\theme\navigationItem();
        $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
        $item->setDescription($this->lang->translate('FPCM_CLASSICIMPORTER_HEADLINE'));
        $item->setIcon('fa fa-clipboard fa-fw');
        $item->setPermission(['system' => 'options']);

        return $item;
        
    }

}
