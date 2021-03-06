<?php
    /**
     * Tweet Extender, https://nobody-knows.org/
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

            $this->dbcon->execYaTdl(__DIR__.'/data/table.yml');

            return true;
        }

        public function runUninstall() {
            
            $this->dbcon->drop(self::NKORGTWEETEXTENDER_TABLE_NAME);
            
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
