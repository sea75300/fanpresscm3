<?php
    /**
     * Language Editor, http://nobody-knows.org
     *
     * nkorg/langeditor event class: navigationAdd
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\langeditor\events;

    class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            if (!\fpcm\classes\baseconfig::$fpcmSession->getCurrentUser()->isAdmin()) {
                return $params;
            }
            
            $params['after'][] = array(
                'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
                'permission'        => array('system' => 'options'),
                'description'       => $this->lang->translate('NKORG_LANGEDITOR_HEADLINE'),
                'icon'              => 'fa fa-language fa-fw',
                'class'             => '',
                'id'                => ''
            );
            
            return $params;
        }

    }