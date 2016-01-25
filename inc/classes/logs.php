<?php
    /**
     * FanPress CM log class
     * 
     * Class to handle logs
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * Logs
     * 
     * @package fpcm.classes.logs
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class logs {
        
        /**
         * Schreibt Daten in System-Log
         * @param string $data
         * @return boolean
         */
        public static function syslogWrite($data) {
            $data   = is_array($data) || is_object($data)
                    ? print_r($data, true)
                    : $data;

            if (file_put_contents(baseconfig::$logFiles['syslog'], json_encode(array('time' => date('Y-m-d H:i:s'),'text' => $data)).PHP_EOL, FILE_APPEND) === false) {
                trigger_error('Unable to write data to system log');
                return false;
            }
            
            return true;
        }
        
        /**
         * Schreibt Daten in SQL-Log
         * @param string $data
         * @return boolean
         */
        public static function sqllogWrite($data) {
            $data   = is_array($data) || is_object($data)
                    ? print_r($data, true)
                    : $data;

            if (file_put_contents(baseconfig::$logFiles['dblog'], json_encode(array('time' => date('Y-m-d H:i:s'),'text' => $data)).PHP_EOL, FILE_APPEND) === false) {
                trigger_error('Unable to write data to db log');
                return false;
            }
            
            return false;
        }

        /**
         * Schreibt Daten in SQL-Log
         * @param string $packageName
         * @param array $data
         * @return boolean
         * @since FPCM 3.2.0
         */
        public static function pkglogWrite($packageName, array $data) {
            if (file_put_contents(baseconfig::$logFiles['pkglog'], json_encode(array('time' => date('Y-m-d H:i:s'), 'pkgname' => $packageName, 'text' => $data)).PHP_EOL, FILE_APPEND) === false) {
                trigger_error('Unable to write data to db log');
                return false;
            }
            
            return false;
        }
        
        /**
         * Ließt Daten aus System-Log
         * @return array
         */
        public static function syslogRead() {
            if (!file_exists(baseconfig::$logFiles['syslog'])) return array();
            
            $content = file(baseconfig::$logFiles['syslog'], FILE_SKIP_EMPTY_LINES);

            if ($content === false) {
                trigger_error('Unable to read data to system log');
                return array();
            }

            return $content;
            
        }
        
        /**
         * Ließt Daten aus Error-Log
         * @return array
         */
        public static function errorlogRead() {            
            if (!file_exists(baseconfig::$logFiles['phplog'])) return array();
            
            $content = file(baseconfig::$logFiles['phplog'], FILE_SKIP_EMPTY_LINES);

            if ($content === false) {
                trigger_error('Unable to read data to system log');
                return array();
            }

            return $content;
            
        }
        
        /**
         * Ließt Daten aus SQL-Log
         * @return array
         */
        public static function sqllogRead() {
            if (!file_exists(baseconfig::$logFiles['dblog'])) return array();
            
            $content = file(baseconfig::$logFiles['dblog'], FILE_SKIP_EMPTY_LINES);

            if ($content === false) {
                trigger_error('Unable to read data to db log');
                return array();
            }

            return $content;
            
        }
        
        /**
         * Ließt Daten aus SQL-Log
         * @return array
         * @since FPCM 3.2.0
         */
        public static function pkglogRead() {
            if (!file_exists(baseconfig::$logFiles['pkglog'])) return array();
            
            $content = file(baseconfig::$logFiles['pkglog'], FILE_SKIP_EMPTY_LINES);

            if ($content === false) {
                trigger_error('Unable to read data to package manager log');
                return array();
            }

            return $content;
            
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
            switch ($log) {
                case 1 :
                    $file = baseconfig::$logFiles['syslog'];
                    break;
                case 2 :
                    $file = baseconfig::$logFiles['phplog'];
                    break;
                case 3 :
                    $file = baseconfig::$logFiles['dblog'];
                    break;
                case 4 :
                    $file = baseconfig::$logFiles['pkglog'];
                    break;
                default:
                    return baseconfig::$fpcmSession->clearSessions();
            }
            
            if (isset($file)) {
                if (file_put_contents($file, '') === false) {
                    trigger_error('Unable to clear logfile: '.$file);
                    return false;
                }
                
                return true;
            }
            
        }
        
    }
?>