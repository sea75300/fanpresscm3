<?php

namespace fpcm\modules\nkorg\modulecreator\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $item = new \fpcm\model\theme\navigationItem();
        $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
        $item->setDescription($this->lang->translate('NKORG_MODULECREATOR_HEADLINE'));
        $item->setIcon('fa fa-truck fa-fw');
        $item->setPermission([
            'system'  => 'options',
            'modules' => 'configure',
            'modules' => 'install',
            'modules' => 'enable'
        ]);

        return $item;
        
    }

}
