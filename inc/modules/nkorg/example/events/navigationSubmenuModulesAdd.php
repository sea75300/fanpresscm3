<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: navigationSubmenuModulesAdd
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class navigationSubmenuModulesAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            return \fpcm\model\theme\navigationItem::createItemFromArray([
                'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
                'permission'        => array('system' => 'options'),
                'description'       => $this->lang->translate('FPCM_EXAMPLE_HEADLINE')
            ]);

        }

    }