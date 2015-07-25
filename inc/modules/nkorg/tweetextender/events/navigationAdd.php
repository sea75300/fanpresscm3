<?php
    /**
     * Tweet Extender, http://nobody-knows.org/
     *
     * nkorg/tweetextender event class: navigationAdd
     * 
     * @version 3.0.0
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\tweetextender\events;

class navigationAdd extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $params['after'][] = array(
            'url'               => 'modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__),
            'permission'        => array('system' => 'options'),
            'description'       => $this->lang->translate('NKORG_TWEETENTENDER_HEADLINE'),
            'icon'              => 'fa fa-twitter-square fa-fw',
            'class'             => '',
            'id'                => ''
        );
        
        return $params;
        
    }

}
