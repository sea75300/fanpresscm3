<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: extendHelp
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class extendHelp extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $params['FPCM_EXAMPLE_HEADLINE'] = 'This is an example help entry!';

            return $params;
        }

    }