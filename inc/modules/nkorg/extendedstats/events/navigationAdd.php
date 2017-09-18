<?php
    /**
     * Extended statistics
     *
     * nkorg/extendedstats event class: navigationAdd
     * 
     * @version 1.0.0
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2017, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\extendedstats\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $item = new \fpcm\model\theme\navigationItem();
            $item->setDescription($this->lang->translate('NKORG_EXTENDEDSTATS_HEADLINE'));
            $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
            $item->setIcon('fa fa-line-chart fa-fw');
            $item->setPermission(['system' => 'options']);
            
            return $item;
        }

    }