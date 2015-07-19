<?php
    /**
     * FanPress CM clear log files Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob filemanger thumbnail creation
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class fmThumbs extends \fpcm\model\abstracts\cron {

        /**
         * Auszuführender Cron-Code
         */
        public function run() {

            $imageList = new \fpcm\model\files\imagelist();
            $imageList->createFilemanagerThumbs();

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
            return 3600 * 24 * 7;
        }
        
    }
