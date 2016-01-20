<?php
    /**
     * FanPress CM Cronjob list
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob list object
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class cronlist extends \fpcm\model\abstracts\staticModel {

        /**
         * Konstruktor
         */
        public function __construct() {
            $this->events = new \fpcm\model\events\eventList();
        }
        
        /**
         * Cronjob zur Ausführung registrieren
         * @param string $cronName
         * @param bool $async
         * @return boolean
         */
        public function registerCron($cronName, $async = false) {

            $cronName = "\\fpcm\\model\\crons\\$cronName";

            if (!class_exists($cronName)) {
                trigger_error("Undefined cronjon {$cronName} called");
                return false;
            }
            
            /**
             * @var \fpcm\model\abstracts\cron
             */
            $cron = new $cronName($cronName);
            
            if (!is_a($cron, '\fpcm\model\abstracts\cron')) {
                trigger_error("Cronjob class {$cronName} must be an instance of \"\fpcm\model\abstracts\cron\"!");
                return false;                
            }
            
            if ($async && !$cron->getRunAsync()) {
                return false;
            }
            
            if (!$cron->checkTime()) {
                return null;
            }

            $cron->setAsyncCurrent($async);
            $cron->run();
            
            $cron->updateLastExecTime();

            if (!is_null($cron->getReturnData())) return $cron->getReturnData();
            
            return true;            
        }
        
        /**
         * Cronjob zur Ausführung via AJAX registrieren
         * @param \fpcm\model\abstracts\cron $cron
         * @return boolean
         * @since FPCM 3.2.0
         */
        public function registerCronAjax(\fpcm\model\abstracts\cron $cron) {

            if (!is_a($cron, '\fpcm\model\abstracts\cron')) {
                trigger_error("Cronjob class {$cronName} must be an instance of \"\fpcm\model\abstracts\cron\"!");
                return false;                
            }
            
            if (!$cron->getRunAsync()) {
                return false;
            }

            $cron->run();
            $cron->updateLastExecTime();
            
            return true;            
        }
        
        /**
         * Cron-Klassen-Liste
         * @return array
         */
        public function getCrons() {
            $cronFiles = glob(\fpcm\classes\baseconfig::$incDir.'model/crons/*.php');
            
            if (!is_array($cronFiles)) return array();

            $crons = array();
            foreach ($cronFiles as $cronFile) {
                if ($cronFile == __FILE__) continue;
                $crons[] = basename($cronFile, '.php');
            }
            
            return $this->events->runEvent('getCronList', $crons);
        }
        
        /**
         * Liefert Liste von Cronjobs, deren letzte Ausführung + Interval <= aktuellen Zeit ist
         * @return array
         * @since FPCM 3.2.0
         */
        public function getExecutableCrons() {
            
            $res = \fpcm\classes\baseconfig::$fpcmDatabase->fetch(
                    \fpcm\classes\baseconfig::$fpcmDatabase->select(
                        \fpcm\classes\database::tableCronjobs,
                        '*',
                        '(lastexec+execinterval) < ?',
                        array(time())
                    ),
                    true
            );

            $list = array();
            
            if (!count($res)) return $list;

            foreach ($res as $value) {
                $cronName = "\\fpcm\\model\\crons\\{$value->cjname}";

                if (!class_exists($cronName)) continue;

                /**
                 * @var \fpcm\model\abstracts\cron
                 */
                $cron = new $cronName($value->cjname, false);

                if (!is_a($cron, '\fpcm\model\abstracts\cron')) {
                    trigger_error("Cronjob class {$cronName} must be an instance of \"\fpcm\model\abstracts\cron\"!");
                    return false;                
                }

                $cron->createFromDbObject($value);
                
                $list[] = $cron;
            }
            
            return $list;
            
        }
        
        /**
         * Cron-Klassen-Liste, wird im Cache vorgehalten
         * @return array
         */
        public function getCronsData() {
            $res = \fpcm\classes\baseconfig::$fpcmDatabase->fetch(\fpcm\classes\baseconfig::$fpcmDatabase->select(\fpcm\classes\database::tableCronjobs), true);
            
            $list = array();
            
            if (!count($res)) return $list;
            
            foreach ($res as $value) {

                $cronName = "\\fpcm\\model\\crons\\{$value->cjname}";

                if (!class_exists($cronName)) continue;

                /**
                 * @var \fpcm\model\abstracts\cron
                 */
                $cron = new $cronName($value->cjname, false);

                if (!is_a($cron, '\fpcm\model\abstracts\cron')) {
                    trigger_error("Cronjob class {$cronName} must be an instance of \"\fpcm\model\abstracts\cron\"!");
                    return false;                
                }
                
                $cron->createFromDbObject($value);
                
                $list[] = $cron;
            }
            
            return $list;
            
        }
    }