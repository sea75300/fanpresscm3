<?php
    /**
     * Module-Event: navigationSubmenuModulesAdd
     * 
     * Event wird ausgeführt, wenn Untermenü "Module" der Navogation erzeugt wird
     * Parameter: array Menüstruktur
     * Rückgabe: array Menüstruktur
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: navigationSubmenuModulesAdd
     * 
     * Event wird ausgeführt, wenn Untermenü "Module" der Navogation erzeugt wird
     * Parameter: array Menüstruktur
     * Rückgabe: array Menüstruktur
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class navigationSubmenuModulesAdd extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Untermenü "Module" der Navogation erzeugt wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/navigationSubmenuModulesAdd.php');
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'navigationSubmenuModulesAdd');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }
            
            if (!count($mdata)) return $data;
            
            return $mdata;
            
        }
    }