<?php
    /**
     * Module-Event: reloadFileList
     * 
     * Event wird ausgeführt, wenn Dateiliste in Dateimanager via AJAX neu geladen wird
     * Parameter: array Liste mit Dateieinträgen
     * Rückgabe: array Liste mit Dateienträgen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: reloadFileList
     * 
     * Event wird ausgeführt, wenn Dateiliste in Dateimanager via AJAX neu geladen wird
     * Parameter: array Liste mit Dateieinträgen
     * Rückgabe: array Liste mit Dateienträgen
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class reloadFileList extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Dateiliste neu geladen wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/reloadFileList.php');
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'reloadFileList');
                
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