<?php
    /**
     * FanPress CM Integration, https://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: navigationAdd
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\integration\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $item = new \fpcm\model\theme\navigationItem();
            $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
            $item->setDescription($this->lang->translate('NKORG_INTEGRATION_HEADLINE'));
            $item->setIcon('fa fa-university fa-fw');
            $item->setPermission(['system' => 'options']);

            return $item;

        }

    }