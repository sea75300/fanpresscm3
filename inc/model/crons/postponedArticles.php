<?php
    /**
     * FanPress CM Postponed Article Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob postponed article publishing
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class postponedArticles extends \fpcm\model\abstracts\cron {

        /**
         * Auszuführender Cron-Code
         */
        public function run() {

            $articlesList = new \fpcm\model\articles\articlelist();
            $articleIds   = $articlesList->getArticlesPostponedIDs();
            
            if (!count($articleIds)) {
                return true;
            }
            
            $articlesList->publishPostponedArticles($articleIds);
            
            return true;            
        }
        
        /**
         * Häufigkeit der Ausführung einschränken
         * @return boolean
         */        
        public function checkTime() {
            
            if (time() < $this->getNextExecTime()) return false;

            return true;
        }
        
        /**
         * Interval-Dauer zurückgeben
         * @return int
         */
        public function getIntervalTime() {
            return 600;
        }
        
    }
