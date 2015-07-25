<?php
    /**
     * Tweet Extender, http://nobody-knows.org/
     *
     * nkorg/tweetextender class: nkorgtweetextender
     * 
     * @version 3.0.0
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\tweetextender;

    class nkorgtweetextender extends \fpcm\model\abstracts\module {

        const NKORGTWEETEXTENDER_TABLE_NAME = 'nkorgtweetextender_terms';
        
        public function runInstall() {
            
            $dbStruct = file_get_contents(__DIR__.'/data/table.sql');            
            $dbStruct = str_replace(array('{{dbpref}}', '{{tablename}}'), array($this->dbcon->getDbprefix(), self::NKORGTWEETEXTENDER_TABLE_NAME), $dbStruct);
            
            $this->dbcon->exec($dbStruct);
            
            return true;
        }

        public function runUninstall() {
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
