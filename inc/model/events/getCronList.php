<?php
    /**
     * Module-Event: getCronList
     * 
     * Event wird ausgeführt, wenn Liste von Cronjob-Dateien für asynchrone Ausführung geladen wird
     * Parameter: array mit Dateiliste von Cronjob-Classen
     * Rückgabe: array mit Dateiliste von Cronjob-Classen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: getCronList
     * 
     * Event wird ausgeführt, wenn Liste von Cronjob-Dateien für asynchrone Ausführung geladen wird
     * Parameter: array mit Dateiliste von Cronjob-Classen
     * Rückgabe: array mit Dateiliste von Cronjob-Classen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class getCronList extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Liste von Cronjob-Dateien für asynchrone Ausführung geladen wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/getCronList.php');
            
            if (!count($eventClasses)) return array();
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'getCronList');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }
            
            if (!isset($mdata)) return $data;
            
            return $mdata;
            
        }
    }