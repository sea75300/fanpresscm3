<?php
    /**
     * FanPress CM Integration, http://nobody-knows.org/fanpress3
     *
     * nkorg/integration event class: navigationAdd
     * 
     * @version 0.0.1
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\integration\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            $params['after'][] = array(
                'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
                'permission'        => array('system' => 'options'),
                'description'       => $this->lang->translate('NKORG_INTEGRATION_HEADLINE'),
                'icon'              => 'fa fa-university fa-fw',
                'class'             => '',
                'id'                => ''
            );
            return $params;
        }

    }