<?php
    /**
     * Module-Event: publicPageinationShowAll
     * 
     * Event wird ausgeführt, wenn Seitenavigation in publicController showAll initialisiert wird
     * Parameter: string HTML-Code der Navigation
     * Rückgabe: string HTML-Code der Navigation
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: publicPageinationShowAll
     * 
     * Event wird ausgeführt, wenn Seitenavigation in publicController showAll initialisiert wird
     * Parameter: string HTML-Code der Navigation
     * Rückgabe: string HTML-Code der Navigation
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm/model/events
     */
    final class publicPageinationShowAll extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Seitenavigation in publicController showAll initialisiert wird
         * @param string $data
         * @return string
         */
        public function run($data = null) {
            
            $eventClasses = $this->getEventClasses();
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'publicPageinationShowAll');
                
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