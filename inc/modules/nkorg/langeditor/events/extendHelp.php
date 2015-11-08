<?php
    /**
     * Language Editor, http://nobody-knows.org
     *
     * nkorg/langeditor event class: extendHelp
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\langeditor\events;

    class extendHelp extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $datapath = \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$dataDir.'langeditback/');
            $params['NKORG_LANGEDITOR_HEADLINE'] = $this->lang->translate('NKORG_LANGEDITOR_MANAGER_HELP', array('{{datapath}}' => $datapath));
            
            return $params;
        }

    }