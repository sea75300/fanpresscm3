<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
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

            $params['after'][] = array(
                'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
                'permission'        => array('system' => 'options'),
                'description'       => $this->lang->translate('NKORGINACTIVITY_MANAGER_HEADLINE'),
                'icon'              => 'fa fa-calendar fa-fw',
                'class'             => '',
                'id'                => ''
            );
            
            return $params;
        }

    }