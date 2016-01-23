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
            
            if (method_exists($this->dbcon, 'execYaTdl')) {
                $this->dbcon->execYaTdl(__DIR__.'/data/table.yml');
            }
            else {
                $dbStruct = file_get_contents(__DIR__.'/data/table.sql');
                $dbStruct = str_replace(array('{{dbpref}}', '{{tablename}}'), array($this->dbcon->getDbprefix(), self::NKORGINACTIVITY_MANAGER_TABLE_NAME), $dbStruct);
                $this->dbcon->exec($dbStruct);                
            }
            
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
