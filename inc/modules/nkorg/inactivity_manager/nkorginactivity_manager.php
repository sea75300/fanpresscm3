<?php
    /**
     * Inactivity Manager, http://nobody-knows.org/
     *
     * nkorg/inactivity_manager class: nkorginactivity_manager
     * 
     * @version 1.1.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\inactivity_manager;

    class nkorginactivity_manager extends \fpcm\model\abstracts\module {

        const NKORGINACTIVITY_MANAGER_TABLE_NAME = 'nkorginactivity_manager_messages';
        
        public function runInstall() {
            
            $this->dbcon->execYaTdl(__DIR__.'/data/table.yml');
            
            return true;
        }

        public function runUninstall() {
            
            $this->dbcon->drop(self::NKORGINACTIVITY_MANAGER_TABLE_NAME);
            
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
