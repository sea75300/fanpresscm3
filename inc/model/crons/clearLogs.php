<?php
    /**
     * FanPress CM clear log files Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob system logs cleanup
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class clearLogs extends \fpcm\model\abstracts\cron {

        /**
         * Logfile-Größe, bei der automatisch bereinigt werden soll >= 1MB = 1 * 1024 * 1024
         * @var int
         */
        protected $maxsize = 1048576;

        /**
         * Auszuführender Cron-Code
         */
        public function run() {

            if (file_exists(\fpcm\classes\baseconfig::$logFiles['phplog']) && filesize(\fpcm\classes\baseconfig::$logFiles['phplog']) >= $this->maxsize) {
                \fpcm\classes\logs::clearLog('phplog');                
            }

            if (file_exists(\fpcm\classes\baseconfig::$logFiles['syslog']) && filesize(\fpcm\classes\baseconfig::$logFiles['syslog']) >= $this->maxsize) {
                \fpcm\classes\logs::clearLog('syslog');                
            }

            if (file_exists(\fpcm\classes\baseconfig::$logFiles['dblog']) && filesize(\fpcm\classes\baseconfig::$logFiles['dblog']) >= $this->maxsize) {
                \fpcm\classes\logs::clearLog('dblog');                
            }

            return true;
        }
        
    }
