<?php
    /**
     * Module-Event: editorAddLinks
     * 
     * Event wird ausgeführt, wenn im Artikel-Editor die Link-Liste für den "Link einfügen"-Dialog geladen wird
     * Parameter: void
     * Rückgabe: array mit Link-Informationen gemäß dem übergebenen Dummy-Eintrag
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: editorAddLinks
     * 
     * Event wird ausgeführt, wenn im Artikel-Editor die Link-Liste für den "Link einfügen"-Dialog geladen wird
     * Parameter: void
     * Rückgabe: array mit Link-Informationen gemäß dem übergebenen Dummy-Eintrag
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class editorAddLinks extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn im Artikel-Editor die Link-Liste für den "Link einfügen"-Dialog geladen wird
         * @param void $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/editorAddLinks.php');
            
            if (!count($eventClasses)) return array();
            
            $mdata = array(array('label' => '','value' => ''));
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'editorAddLinks');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }

            array_shift($mdata);
            
            return $mdata;
            
        }
    }