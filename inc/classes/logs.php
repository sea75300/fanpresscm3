<?php
    /**
     * FanPress CM log class
     * 
     * Class to handle logs
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * Logs
     * 
     * @package fpcm\classes\logs
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class logs {
        
        /**
         * Schreibt Daten in System-Log
         * @param string $data
         * @return boolean
         * @deprecated FPCM 3.6
         */
        public static function syslogWrite($data) {
            return fpcmLogSystem($data);
        }
        
        /**
         * Schreibt Daten in SQL-Log
         * @param string $data
         * @return boolean
         * @deprecated FPCM 3.6
         */
        public static function sqllogWrite($data) {
            return fpcmLogSql($data);
        }

        /**
         * Schreibt Daten in SQL-Log
         * @param string $packageName
         * @param array $data
         * @return boolean
         * @since FPCM 3.2.0
         * @deprecated FPCM 3.6
         */
        public static function pkglogWrite($packageName, array $data) {
            return fpcmLogPackages($packageName, $data);
        }
        
        /**
         * Leer System-Log
         * @param int $log
         * * 1 => System-Log
         * * 2 => PHP Error Log
         * * 3 => Datenbank-Log
         * * 4 => Paket-Manager-Log
         * * default: Session-Log
         * @return boolean
         */
        public static function clearLog($log) {
            
            if ($log < 1) {
                return baseconfig::$fpcmSession->clearSessions();
            }
            
            $logfile = new \fpcm\model\files\logfile($log);
            return $logfile->clear();
            
        }
        
    }
?>