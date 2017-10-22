<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example class: nkorgexample
     * 
     * @version 3.6.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example;

    class nkorgexample extends \fpcm\model\abstracts\module {

        public function runInstall() { 
            return true;
        }

        public function runUninstall() {
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
