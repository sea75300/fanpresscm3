<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: navigationAdd
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $item = new \fpcm\model\theme\navigationItem();
            $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
            $item->setDescription($this->lang->translate('FPCM_EXAMPLE_HEADLINE'));
            $item->setIcon('fa fa-check-square-o fa-fw');
            $item->setPermission(['system' => 'options']);

            return $item;  

        }

    }