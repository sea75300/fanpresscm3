<?php
    /**
     * Language Editor, http://nobody-knows.org
     *
     * nkorg/langeditor class: nkorglangeditor
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\langeditor;

    class nkorglangeditor extends \fpcm\model\abstracts\module {

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
