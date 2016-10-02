<?php
    /**
     * Module-Event: commentsByCondition
     * 
     * Event wird ausgeführt, wenn Kommentar-Suche ausgeführt wird
     * Parameter: array Suchbedingungen
     * Rückgabe: array Suchbedingungen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.4
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: commentsByCondition
     * 
     * Event wird ausgeführt, wenn Kommentar-Suche ausgeführt wird
     * Parameter: array Suchbedingungen
     * Rückgabe: array Suchbedingungen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm/model/events
     * @since FPCM 3.4
     */
    final class commentsByCondition extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Kommentar-Suche ausgeführt wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = $this->getEventClasses();
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'commentsByCondition');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }

            if (!$mdata || !is_array($mdata) || !isset($eventData['where']) || !is_array($eventData['where']) || !isset($eventData['conditions']) || !is_array($eventData['conditions'])) {
                return $data;
            }

            return $mdata;
            
        }
    }