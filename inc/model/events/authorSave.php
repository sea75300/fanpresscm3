<?php
    /**
     * Module-Event: authorSave
     * 
     * Event wird ausgeführt, wenn ein neuer Benutzer gespeichert angelegt wird
     * Parameter: array mit Benutzerdaten
     * Rückgabe: array mit Benutzerdaten
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: authorSave
     * 
     * Event wird ausgeführt, wenn ein neuer Benutzer gespeichert angelegt wird
     * Parameter: array mit Benutzerdaten
     * Rückgabe: array mit Benutzerdaten
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class authorSave extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Benutzer gespeichert wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/authorSave.php');
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'authorSave');
                
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