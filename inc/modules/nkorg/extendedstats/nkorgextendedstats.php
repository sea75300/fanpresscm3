<?php
    /**
     * Extended statistics
     *
     * nkorg/extendedstats class: nkorgextendedstats
     * 
     * @version 1.0.0
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2017, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\extendedstats;

    class nkorgextendedstats extends \fpcm\model\abstracts\module {

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
