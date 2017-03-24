<?php
    /**
     * Inactivity Manager, https://nobody-knows.org/
     *
     * nkorg/inactivity_manager event class: navigationAdd
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $item = new \fpcm\model\theme\navigationItem();
            $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
            $item->setDescription($this->lang->translate('NKORGINACTIVITY_MANAGER_HEADLINE'));
            $item->setIcon('fa fa-calendar fa-fw');
            $item->setPermission(['system' => 'options']);

            return $item;
        }

    }