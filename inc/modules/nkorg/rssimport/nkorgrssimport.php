<?php
    /**
     * RSS Importer, http://nobody-knows.org
     *
     * nkorg/rssimport class: nkorgrssimport
     * 
     * @version 0.0.1
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2016, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\rssimport;

    class nkorgrssimport extends \fpcm\model\abstracts\module {

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
