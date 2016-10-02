<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: navigationAdd
     * 
     * @version 3.4.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $params['after'][] = array(
                'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
                'permission'        => array('system' => 'options'),
                'description'       => $this->lang->translate('FPCM_EXAMPLE_HEADLINE'),
                'icon'              => 'fa fa-check-square-o fa-fw',
                'class'             => '',
                'id'                => ''
            );
  
            return $params;
        }

    }