<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: logsAddList
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class logsAddList extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $params[] = array(
                'id'        => 'nkorgexample',
                'title'     => 'FPCM_EXAMPLE_HEADLINE',
                'template'  => dirname(__DIR__).'/views/logview.php'
            );

            return $params;
        }

    }