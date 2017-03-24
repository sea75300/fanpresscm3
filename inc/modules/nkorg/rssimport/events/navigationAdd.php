<?php

namespace fpcm\modules\nkorg\rssimport\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $item = new \fpcm\model\theme\navigationItem();
        $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
        $item->setDescription($this->lang->translate('NKORG_RSSIMPORT_HEADLINE'));
        $item->setIcon('fa fa-feed fa-fw');
        $item->setPermission(['system' => 'options']);

        return $item;
        
    }

}
