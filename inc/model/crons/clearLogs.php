<?php
    /**
     * FanPress CM clear log files Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob system logs cleanup
     * 
     * @package fpcm\model\crons
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

            $dateStr = date('Ymd').'.txt';

            $logFileSystem = \fpcm\classes\baseconfig::$logFiles['syslog'];
            if (file_exists($logFileSystem) && filesize($logFileSystem) >= $this->maxsize) {
                fpcmLogCron('Cleanup system log...');
                copy($logFileSystem, $logFileSystem.'.'.$dateStr);
                \fpcm\classes\logs::clearLog(1);                
            }
            
            $logFilePhp = \fpcm\classes\baseconfig::$logFiles['phplog'];
            if (file_exists($logFilePhp) && filesize($logFilePhp) >= $this->maxsize) {
                fpcmLogCron('Cleanup php log...');
                copy($logFilePhp, $logFilePhp.'.'.$dateStr);
                \fpcm\classes\logs::clearLog(2);                
            }

            $logFileDbms = \fpcm\classes\baseconfig::$logFiles['dblog'];
            if (file_exists($logFileDbms) && filesize($logFileDbms) >= $this->maxsize) {
                fpcmLogCron('Cleanup sql log...');
                copy($logFileDbms, $logFileDbms.'.'.$dateStr);
                \fpcm\classes\logs::clearLog(3);                
            }

            $logFilePkgMgr = \fpcm\classes\baseconfig::$logFiles['pkglog'];
            if (file_exists($logFilePkgMgr) && filesize($logFilePkgMgr) >= $this->maxsize) {
                fpcmLogCron('Cleanup package manager log...');
                copy($logFilePkgMgr, $logFilePkgMgr.'.'.$dateStr);
                \fpcm\classes\logs::clearLog(4);                
            }

            return true;
        }
        
    }
