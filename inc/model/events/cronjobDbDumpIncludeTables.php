<?php
    /**
     * Module-Event: cronjobDbDumpIncludeTables
     * 
     * Event wird ausgeführt, wenn Cronjob für automatische Datenbank-Sicherung läuft
     * Parameter: array mit Liste der zu sichernden Tabellen
     * Rückgabe: array mit Liste der zu sichernden Tabellen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: cronjobDbDumpIncludeTables
     * 
     * Event wird ausgeführt, wenn Cronjob für automatische Datenbank-Sicherung läuft
     * Parameter: array mit Liste der zu sichernden Tabellen
     * Rückgabe: array mit Liste der zu sichernden Tabellen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     * @since FPCM 3.1
     */
    final class cronjobDbDumpIncludeTables extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Systemcheck durchgführt wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/cronjobDbDumpIncludeTables.php');
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'cronjobDbDumpIncludeTables');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }

            if (!$mdata) return $data;

            return $mdata;
            
        }
    }