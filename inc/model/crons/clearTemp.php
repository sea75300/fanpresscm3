<?php
    /**
     * FanPress CM temp file cleanup cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob temp files cleanup
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class clearTemp extends \fpcm\model\abstracts\cron {

        /**
         * Auszuführender Cron-Code
         */
        public function run() {

            if (!is_writable(\fpcm\classes\baseconfig::$tempDir)) {
                trigger_error('Unable to cleanup '.\fpcm\classes\baseconfig::$tempDir.'! Access denied!');
                return false;
            }
            
            $tempFiles = glob(\fpcm\classes\baseconfig::$tempDir.'*');
            
            foreach ($tempFiles as $tempFile) {
                
                if ($tempFile == \fpcm\classes\baseconfig::$tempDir.'index.html') continue;
                
                if (filectime($tempFile) + 3600 * 24 > time()) continue;
                
                if (is_dir($tempFile)) {
                    \fpcm\model\files\ops::deleteRecursive($tempFile);
                    continue;
                }
                unlink($tempFile);
            }

            \fpcm\classes\logs::syslogWrite('Temp files cleanup in '.\fpcm\classes\baseconfig::$tempDir);
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
