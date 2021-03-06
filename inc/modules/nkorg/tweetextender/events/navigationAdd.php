<?php
    /**
     * Tweet Extender, https://nobody-knows.org/
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

        $item = new \fpcm\model\theme\navigationItem();
        $item->setUrl('modules/config&key='.\fpcm\model\abstracts\module::getModuleKeyByFolder(__FILE__));
        $item->setDescription($this->lang->translate('NKORG_TWEETENTENDER_HEADLINE'));
        $item->setIcon('fa fa-twitter-square fa-fw');
        $item->setPermission(['system' => 'options']);

        return $item;
        
    }

}
